<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\ManagementProduct;
use App\Models\Transaction;
use App\Utils\UploadFile;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class CartRepositories
{
    public function __construct(
        protected readonly Cart $cart,
        protected readonly ShippingRepositories $shipping,
        protected readonly ProductRepositories $product,
        protected readonly ResellerRepositories $reseller,
        protected readonly TransactionRepositories $transactionRepo,
        protected readonly Transaction $transaction,
        protected readonly UploadFile $uploadFile,
        protected readonly ManagementProduct $managementProduct,
    ) {
    }

    public function findAll()
    {
        return $this->cart->whereNull('invois')->where('status', 1)->get();
    }

    public function findLatest()
    {
        return $this->cart->whereNull('invois')->where('status', 0)->latest()->first();
    }

    public function findWhereIn($cart_id)
    {
        return $this->cart->whereNull('invois')->where('status', 1)->whereIn('id', [$cart_id])->latest()->get();
    }

    public function findAllByUserId(int $user_id)
    {
        return $this->cart->whereNull('invois')->where('status', 1)->where('users_id', $user_id)->latest()->get();
    }

    public function findAllPaginate()
    {
        return $this->cart->whereNull('invois')->where('status', 1)->get();
    }

    public function findById($cart_id)
    {
        return $this->cart->where('id', $cart_id)->first();
    }

    public function findByIdAndInvois($cart_id)
    {
        return $this->cart->where('id', $cart_id)->orWhere('invois', $cart_id)->first();
    }

    public function findAllByIdAndInvois($cart_id)
    {
        return $this->cart->where('id', $cart_id)->orWhere('invois', $cart_id)->get();
    }

    public function findAllById($cart_id)
    {
        return Cart::whereIn('id', $cart_id)->get();
    }

    public function findByProductId(int $product_id, int $user_id)
    {
        return $this->cart->whereNull('invois')->where('users_id', $user_id)->where('status', 1)->where('products_id', $product_id)->first();
    }

    public function store($request)
    {
        $cart = $this->findByProductId($request['products_id'], auth()->user()->id);
        if ($cart != null) {
            $request['quantity'] += $cart['quantity'];
            return $cart->update($request);
        } else {
            return $this->cart->create($request);
        }
    }

    public function storeTransaction($request)
    {
        $requestData = $request->all();
        $requestData['status'] = 0;
        return $this->cart->create(Arr::only($requestData, ['users_id', 'products_id', 'quantity', 'status']));
    }

    public function storeProduct($request, $cart_id)
    {
        $cartSelected = $this->findById($cart_id);
        if ($cartSelected->invois == null) {
            if (auth()->user()->role == 'reseller') {
                $reseller = $this->reseller->findByUserId($cartSelected->users_id);
                $request['resellers_id'] = $reseller->id;
            }
            if ($request['resellers_id'] != null) {
                $reseller = $this->reseller->findById($request['resellers_id']);
                $request['resellers_id'] = $reseller->id;
            }
            $request['price_per_product'] = str_replace('Rp. ', '', $request['price_per_product']);
            $request['price_per_product'] = (int) str_replace('.', '', $request['price_per_product']);
            $request['status'] = 2;
            $cartSelected->update(Arr::only($request, ['quantity', 'invois', 'status']));
            return $this->transaction->create($request);
        } else {
            $request['total'] = str_replace('Rp. ', '', $request['total']);
            $request['total'] = (int) str_replace('.', '', $request['total']);
            $dateNow = Carbon::now();
            $dateDayLimit = Carbon::parse($cartSelected->updated_at)->addDay();
            $transactions = $this->transactionRepo->findByInvois($cartSelected->invois);
            if ($dateNow <= $dateDayLimit) {
                if (isset($request['proof_of_payment'])) {
                    $request['proof_of_payment'] = $this->uploadFile->uploadSingleFile($request['proof_of_payment'], "assets/images/transaction");
                }
                $product = $this->product->findById($cartSelected->products_id);
                $this->managementProduct->create([
                    'products_id' => $product->id,
                    'type' => 'purchased',
                    'quantity' => $cartSelected->quantity,
                ]);
                $request['stock'] = $product->stock - $cartSelected->quantity;
                if (auth()->user()->role == 'reseller') {
                    $request['status'] = 0;
                } else {
                    $request['status'] = 1;
                }
                if ($transactions[0]->resellers_id != null && auth()->user()->role != 'reseller') {
                    $reseller = $this->reseller->findById($transactions[0]->resellers_id);
                    $request['poin'] = $reseller->poin + $cartSelected->quantity;
                    $reseller->update(Arr::only($request, 'poin'));
                }
                $cartSelected->delete();
                $product->update(Arr::only($request, 'stock'));
                return $transactions[0]->update(Arr::except($request, ['stock', 'poin']));
            } else {
                $cartSelected->delete();
                $transactions[0]->delete();
            }
        }
    }

    public function update($request, int $cart_id)
    {
        $cartSelected = $this->findById($cart_id);
        if (isset($request['proof_of_payment'])) {
            $request['proof_of_payment'] = $this->uploadFile->uploadSingleFile($request['proof_of_payment'], "assets/images/transaction");
        }
        $product = $this->product->findById($request['products_id']);
        $request['invois'] = strtoupper(substr($product->name, 0, 3)) . '-' . rand();
        $request['stock'] = $product->stock - $request['quantity'];
        if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin' || auth()->user()->role == 'reseller') {
            if ($request['resellers_id']) {
                if (auth()->user()->role == 'reseller') {
                    $reseller = $this->reseller->findByUserId($request['resellers_id']);
                    $request['resellers_id'] = $reseller->id;
                } elseif (auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin') {
                    $reseller = $this->reseller->findById($request['resellers_id']);
                }
                $request['poin'] = $reseller->poin + $request['quantity'];
                $reseller->update(Arr::only($request, 'poin'));
            }
        }
        $cartSelected->delete();
        $product->update(Arr::only($request, 'stock'));
        return $this->transaction->create(Arr::except($request, 'stock'));
    }

    public function delete($cart): bool
    {
        return $cart->delete();
    }
}
