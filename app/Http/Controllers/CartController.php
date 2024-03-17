<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\StoreTransactionRequest;
use App\Models\Cart;
use App\Repositories\CartRepositories;
use App\Repositories\CustomerRepositories;
use App\Repositories\PackageRepositories;
use App\Repositories\ProductRepositories;
use App\Repositories\ResellerRepositories;
use App\Repositories\TransactionRepositories;
use App\Utils\UploadFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Arr;

class CartController extends Controller
{
    public function __construct(
        protected readonly CartRepositories $cart,
        protected readonly TransactionRepositories $transaction,
        protected readonly CustomerRepositories $customer,
        protected readonly ProductRepositories $product,
        protected readonly PackageRepositories $package,
        protected readonly ResellerRepositories $reseller,
        protected readonly UploadFile $uploadFile,
    ) {}

    public function index() : View {
        return view('homepage.cart', [
            'title' => 'Halaman Keranjang',
            'carts' => $this->cart->findAllByUserId(auth()->user()->id),
        ]);
    }

    public function createSession(Request $request) {
        if ($request->cart_id == null) {
            $this->cart->storeTransaction($request);
            $cartIdSelect = $this->cart->findLatest()->id;
        } else {
            foreach ($request->cart_id as $cart_id) {
                $cart = $this->cart->findById($cart_id);
                if ($cart->product->stock < $cart->quantity) {
                    return redirect(route('cart.index'))->with('failed', 'Stock produk telah habis!');
                }
                $cart->update(['status' => 2]);
            }
            $cartIdSelect = implode('+', $request->cart_id);
        }
        return redirect(route('cart.edit', $cartIdSelect));
    }

    public function store(StoreCartRequest $request) : RedirectResponse {
        try {
            $this->cart->store($request->validated());
            return redirect(route('cart.index'))->with('success', 'Berhasil menambahkan produk di keranjang!');
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect(route('cart.index'))->with('failed', 'Gagal menambahkan produk di keranjang!');
        }
    }

    public function storeTransaction(StoreCartRequest $request) : RedirectResponse {
        try {
            $this->cart->storeTransaction($request->validated());
            return redirect(route('cart.edit', $this->cart->findLatest()->id))->with('success', 'Berhasil menambahkan produk di keranjang!');
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect(route('product.show', $request['products_id']))->with('failed', 'Gagal beli produk!');
        }
    }

    public function edit($id) {
        $cartIdSelect = explode('+', $id);
        $view = 'homepage.cart-transaction';
        if (count($cartIdSelect) == 1) {
            $cart = $this->cart->findById($id);
            if ($cart->product->stock == 0) {
                $this->cart->delete($cart);
                return redirect(route('cart.index'))->with('failed', 'Stok pada produk ini telah habis!');
            }
        } else {
            $cart = [];
            foreach ($cartIdSelect as $cartId) {
                $cartSelect = $this->cart->findById($cartId);
                if ($cartSelect->product->stock == 0) {
                    $this->cart->delete($cartSelect);
                    return redirect(route('cart.index'))->with('failed', 'Stok pada produk ' . $cartSelect->product->name . ' telah habis!');
                } else {
                    $cart[] = $cartSelect;
                    $view = 'homepage.cart-transaction-multiple';
                }
            }
        }

        if (auth()->user()->role == 'customer') {
            return view($view, [
                'title' => 'Halaman Transaksi Keranjang',
                'cart' => $cart,
                'customer' => $this->customer->findByUserId(auth()->user()->id),
            ]);
        } elseif (auth()->user()->role == 'reseller') {
            return view($view, [
                'title' => 'Halaman Transaksi Keranjang',
                'cart' => $cart,
                'customers' => $this->customer->findAll(),
                'reseller' => $this->reseller->findByUserId(auth()->user()->id),
            ]);
        } elseif (auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin') {
            return view($view, [
                'title' => 'Halaman Transaksi Keranjang',
                'cart' => $cart,
                'customers' => $this->customer->findAll(),
                'resellers' => $this->reseller->findAll(),
            ]);
        }
    }

    public function storeProduct(StoreTransactionRequest $request, $cart_id) {
        try {
            if (str_contains($cart_id, '+') && $request->total == null) {
                $cartIdSelect = explode('+', $cart_id);
                $requestTemporary = [];
                for ($i=0; $i < count($cartIdSelect) ; $i++) {
                    $requestTemporary['products_id'] = $request['products_id'][$i];
                    $requestTemporary['customers_id'] = $request['customers_id'];
                    $requestTemporary['resellers_id'] = $request['resellers_id'];
                    $requestTemporary['quantity'] = $request['quantity'][$i];
                    $this->cart->storeProduct($requestTemporary, $cartIdSelect[$i]);
                }
                return redirect(route('cart-transaction', $cart_id));
            } else {
                $cartIdSelect = explode('+', $cart_id);

                if(isset($request['proof_of_payment'])) {
                    $request['proof_of_payment'] = $this->uploadFile->uploadSingleFile($request['proof_of_payment'], "assets/images/transaction");
                }

                foreach ($cartIdSelect as $i => $cartId) {
                    $cartSelected = $this->cart->findById($cartId);
                    $product = $this->product->findById($cartSelected->products_id);
                    $request['stock'][$i] = $product->stock - $cartSelected->quantity;
                    $transaction = $this->transaction->findByInvois($cartSelected->invois);
                    if (auth()->user()->role == 'reseller') {
                        $request['status'] = 0;
                    } else {
                        $request['status'] = 1;
                    }
                    if ($transaction->resellers_id != null) {
                        $reseller = $this->reseller->findById($transaction->resellers_id);
                        $request['poin'] = $reseller->poin + $cartSelected->quantity;
                    }
                    // $reseller->update(Arr::only($request->all(), 'poin'));
                    // $cartSelected->delete();
                    // $product->update(Arr::only($request->all(), 'stock'));
                    // $transaction->update(Arr::except($request->all(), ['stock', 'poin']));
                }

                dd($request->all());

                dd('123');

                return redirect(route('cart.index'))->with('success', 'Berhasil menambahkan transaksi baru!');
            }

            $cart = $this->cart->findById($cart_id);
            if ($cart->invois == null) {
                $this->cart->storeProduct($request->validated(), $cart_id);
                return redirect(route('cart-transaction', $cart_id));
            } else {
                $this->cart->storeProduct($request->validated(), $cart_id);
                return redirect(route('cart.index'))->with('success', 'Berhasil menambahkan transaksi baru!');
            }
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect(route('cart.index'))->with('failed', 'Gagal menambahkan transaksi baru!');
        }
    }

    public function cartTransaction($cart_id) {
        if (str_contains($cart_id, '+')) {
            $view = 'homepage.cart-transaction-multiple-payment';
            $cartIdSelect = explode('+', $cart_id);
            $cart = [];
            $package = [];
            foreach ($cartIdSelect as $i => $carts) {
                $cart[] = $this->cart->findById($carts);
                $package[] = $this->package->findWhereProduct($cart[$i]->quantity, $cart[$i]->products_id);
            }
        } else {
            $view = 'homepage.cart-transaction-payment';
            $cart = $this->cart->findById($cart_id);
            $package = $this->package->findWhereProduct($cart->quantity, $cart->products_id);
        }
        return view($view, [
            'title' => 'Halaman Transaksi Pembayaran Keranjang',
            'cart' => $cart,
            'package' => $package,
        ]);
    }

    public function update(StoreTransactionRequest $request, int $cart_id) : RedirectResponse {
        try {
            $this->cart->update($request->validated(), $cart_id);
            return redirect(route('cart.index'))->with('success', 'Berhasil menambahkan transaksi baru!');
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect(route('cart.index'))->with('failed', 'Gagal menambahkan transaksi baru!');
        }
    }

    public function destroy(Cart $cart) : RedirectResponse {
        try {
            $this->cart->delete($cart);
            return redirect(route('cart.index'))->with('success', 'Berhasil hapus produk dari keranjang!');
        } catch (\Exception $e) {
            return redirect(route('cart.index'))->with('failed', 'Gagal hapus produk dari keranjang!');
        }
    }
}
