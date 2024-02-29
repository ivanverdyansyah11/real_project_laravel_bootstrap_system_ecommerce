<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Transaction;
use App\Utils\UploadFile;
use Illuminate\Support\Arr;

class CartRepositories
{
    public function __construct(
        protected readonly Cart $cart,
        protected readonly ProductRepositories $product,
        protected readonly CustomerRepositories $customer,
        protected readonly ResellerRepositories $reseller,
        protected readonly Transaction $transaction,
        protected readonly UploadFile $uploadFile,
    ) {}

    public function findAll()
    {
        return $this->cart->latest()->get();
    }

    public function findAllByUserId(int $user_id)
    {
        return $this->cart->where('users_id', $user_id)->latest()->get();
    }

    public function findAllPaginate()
    {
        return $this->cart->latest()->get();
    }

    public function findById(int $cart_id): Cart
    {
        return $this->cart->where('id', $cart_id)->first();
    }

    public function store($request): Cart
    {
        return $this->cart->create($request);
    }

    public function update($request, int $cart_id)
    {
        $cartSelected = $this->findById($cart_id);
        if(isset($request['proof_of_payment'])) {
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
                } elseif(auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin') {
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
