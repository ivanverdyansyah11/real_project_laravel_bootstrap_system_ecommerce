<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\StoreTransactionRequest;
use App\Repositories\CartRepositories;
use App\Repositories\CustomerRepositories;
use App\Repositories\ResellerRepositories;
use App\Repositories\TransactionRepositories;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        protected readonly CartRepositories $cart,
        protected readonly TransactionRepositories $transaction,
        protected readonly CustomerRepositories $customer,
        protected readonly ResellerRepositories $reseller,
    ) {}

    public function index() : View {
        return view('homepage.cart', [
            'title' => 'Halaman Keranjang',
            'carts' => $this->cart->findAllByUserId(auth()->user()->id),
        ]);
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

    public function edit(int $id) {
        $cart = $this->cart->findById($id);
        if ($cart->product->stock == 0) {
            $this->cart->delete($cart);
            return redirect(route('cart.index'))->with('failed', 'Stok pada produk ini telah habis!');
        } else {
            if (auth()->user()->role == 'customer') {
                return view('homepage.cart-transaction', [
                    'title' => 'Halaman Transaksi Keranjang',
                    'cart' => $cart,
                    'customer' => $this->customer->findByUserId(auth()->user()->id),
                ]);
            } elseif (auth()->user()->role == 'reseller') {
                return view('homepage.cart-transaction', [
                    'title' => 'Halaman Transaksi Keranjang',
                    'cart' => $cart,
                    'customers' => $this->customer->findAll(),
                    'reseller' => $this->reseller->findByUserId(auth()->user()->id),
                ]);
            } elseif (auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin') {
                return view('homepage.cart-transaction', [
                    'title' => 'Halaman Transaksi Keranjang',
                    'cart' => $cart,
                    'customers' => $this->customer->findAll(),
                    'resellers' => $this->reseller->findAll(),
                ]);
            }
        }
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
}
