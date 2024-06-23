<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Repositories\CartRepositories;
use App\Repositories\CustomerRepositories;
use App\Repositories\ProductImageRepositories;
use App\Repositories\ProductRepositories;
use App\Repositories\TransactionRepositories;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function __construct(
        protected readonly ProductRepositories $product,
        protected readonly ProductImageRepositories $productImage,
        protected readonly CustomerRepositories $customer,
        protected readonly TransactionRepositories $transaction,
        protected readonly CartRepositories $cart,
    ) {
    }

    public function index(): View
    {
        if (auth()->user() != null && auth()->user()->role == 'reseller') {
            $transactions = $this->transaction->findAllWithNotification();
            $uniqueTransactions = [];
            $invoiceTransactions = [];
            foreach ($transactions as $transaction) {
                if (!in_array($transaction->invois, $invoiceTransactions)) {
                    $uniqueTransactions[] = $transaction;
                    $invoiceTransactions[] = $transaction->invois;
                }
            }
            $transactions = $uniqueTransactions;
        } else {
            $transactions = [];
        }

//        dd($transactions);

        return view('homepage.index', [
            'title' => 'Halaman Beranda',
            'products' => Transaction::where('status', 1)
                ->with(['product' => function($query) {
                    $query->whereNull('deleted_at');
                }])
                ->selectRaw('products_id, SUM(quantity) as total_quantity')
                ->groupBy('products_id')
                ->orderByDesc('total_quantity')
                ->get()
                ->filter(function ($transaction) {
                    return $transaction->product !== null;
                }),
            'transactions' => $transactions,
            'carts' => $this->cart->findAll(),
        ]);
    }

    public function products(Request $request): View
    {
        if (auth()->user() != null && auth()->user()->role == 'reseller') {
            $transactions = $this->transaction->findAllWithNotification();
            $uniqueTransactions = [];
            $invoiceTransactions = [];
            foreach ($transactions as $transaction) {
                if (!in_array($transaction->invois, $invoiceTransactions)) {
                    $uniqueTransactions[] = $transaction;
                    $invoiceTransactions[] = $transaction->invois;
                }
            }
            $transactions = $uniqueTransactions;
        } else {
            $transactions = [];
        }

        if ($request) {
            $products = Product::where('name', 'LIKE', '%' . $request->search . '%')->get();
            $request = $request->search;
        } else {
            $products = $this->product->findAll();
            $request = null;
        }

        return view('homepage.products', [
            'title' => 'Halaman Produk',
            'products' => $products,
            'transactions' => $transactions,
            'request' => $request,
            'carts' => $this->cart->findAll(),
        ]);
    }

    public function product(int $id): View
    {
        if (auth()->user() != null && auth()->user()->role == 'reseller') {
            $transactions = $this->transaction->findAllWithNotification();
            $uniqueTransactions = [];
            $invoiceTransactions = [];
            foreach ($transactions as $transaction) {
                if (!in_array($transaction->invois, $invoiceTransactions)) {
                    $uniqueTransactions[] = $transaction;
                    $invoiceTransactions[] = $transaction->invois;
                }
            }
            $transactions = $uniqueTransactions;
        } else {
            $transactions = [];
        }

        return view('homepage.product', [
            'title' => 'Halaman Produk',
            'product' => $this->product->findById($id),
            'transactions' => $transactions,
            'product_images' => $this->productImage->findAllWhereByproductId($id),
            'carts' => $this->cart->findAll(),
        ]);
    }

    public function testimonial(): View
    {
        if (auth()->user() != null && auth()->user()->role == 'reseller') {
            $transactions = $this->transaction->findAllWithNotification();
            $uniqueTransactions = [];
            $invoiceTransactions = [];
            foreach ($transactions as $transaction) {
                if (!in_array($transaction->invois, $invoiceTransactions)) {
                    $uniqueTransactions[] = $transaction;
                    $invoiceTransactions[] = $transaction->invois;
                }
            }
            $transactions = $uniqueTransactions;
        } else {
            $transactions = [];
        }

        return view('homepage.testimonial', [
            'title' => 'Halaman Kontak',
            'transactions' => $transactions,
            'carts' => $this->cart->findAll(),
        ]);
    }

    public function contact(): View
    {
        if (auth()->user() != null && auth()->user()->role == 'reseller') {
            $transactions = $this->transaction->findAllWithNotification();
            $uniqueTransactions = [];
            $invoiceTransactions = [];
            foreach ($transactions as $transaction) {
                if (!in_array($transaction->invois, $invoiceTransactions)) {
                    $uniqueTransactions[] = $transaction;
                    $invoiceTransactions[] = $transaction->invois;
                }
            }
            $transactions = $uniqueTransactions;
        } else {
            $transactions = [];
        }

        return view('homepage.contact', [
            'title' => 'Halaman Kontak',
            'transactions' => $transactions,
            'carts' => $this->cart->findAll(),
        ]);
    }

    public function profile(): View
    {
        if (auth()->user() != null && auth()->user()->role == 'reseller') {
            $transactions = $this->transaction->findAllWithNotification();
            $uniqueTransactions = [];
            $invoiceTransactions = [];
            foreach ($transactions as $transaction) {
                if (!in_array($transaction->invois, $invoiceTransactions)) {
                    $uniqueTransactions[] = $transaction;
                    $invoiceTransactions[] = $transaction->invois;
                }
            }
            $transactions = $uniqueTransactions;
        } else {
            $transactions = [];
        }

        return view('homepage.profile', [
            'title' => 'Halaman Profil',
            'profile' => $this->customer->findByUserId(auth()->user()->id),
            'transactions' => $transactions,
            'carts' => $this->cart->findAll(),
        ]);
    }

    public function orderCompleted(): View
    {
        if (auth()->user() != null && auth()->user()->role == 'reseller') {
            $transactions = $this->transaction->findAllWithNotification();
            $uniqueTransactions = [];
            $invoiceTransactions = [];
            foreach ($transactions as $transaction) {
                if (!in_array($transaction->invois, $invoiceTransactions)) {
                    $uniqueTransactions[] = $transaction;
                    $invoiceTransactions[] = $transaction->invois;
                }
            }
            $transactions = $uniqueTransactions;
        } else {
            $transactions = [];
        }

        return view('homepage.order-completed', [
            'title' => 'Halaman Order Berhasil',
            'transactions' => $transactions,
            'carts' => $this->cart->findAll(),
        ]);
    }
}
