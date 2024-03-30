<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Repositories\CustomerRepositories;
use App\Repositories\ProductRepositories;
use Illuminate\Contracts\View\View;

class HomepageController extends Controller
{
    public function __construct(
        protected readonly ProductRepositories $product,
        protected readonly CustomerRepositories $customer,
    ) {
    }

    public function index(): View
    {
        if (auth()->user() != null && auth()->user()->role == 'reseller') {
            $transactions = Transaction::whereRaw('created_at <> updated_at')->where('status', 2)->get();
        } else {
            $transactions = [];
        }

        return view('homepage.index', [
            'title' => 'Halaman Beranda',
            'products' => $this->product->findAll(),
            'transactions' => $transactions,
        ]);
    }

    public function products(): View
    {
        if (auth()->user() != null && auth()->user()->role == 'reseller') {
            $transactions = Transaction::whereRaw('created_at <> updated_at')->where('status', 2)->get();
        } else {
            $transactions = [];
        }

        return view('homepage.products', [
            'title' => 'Halaman Produk',
            'products' => $this->product->findAll(),
            'transactions' => $transactions,
        ]);
    }

    public function product(int $id): View
    {
        if (auth()->user() != null && auth()->user()->role == 'reseller') {
            $transactions = Transaction::whereRaw('created_at <> updated_at')->where('status', 2)->get();
        } else {
            $transactions = [];
        }

        return view('homepage.product', [
            'title' => 'Halaman Produk',
            'product' => $this->product->findById($id),
            'transactions' => $transactions,
        ]);
    }

    public function testimonial(): View
    {
        if (auth()->user() != null && auth()->user()->role == 'reseller') {
            $transactions = Transaction::whereRaw('created_at <> updated_at')->where('status', 2)->get();
        } else {
            $transactions = [];
        }

        return view('homepage.testimonial', [
            'title' => 'Halaman Kontak',
            'transactions' => $transactions,
        ]);
    }

    public function contact(): View
    {
        if (auth()->user() != null && auth()->user()->role == 'reseller') {
            $transactions = Transaction::whereRaw('created_at <> updated_at')->where('status', 2)->get();
        } else {
            $transactions = [];
        }

        return view('homepage.contact', [
            'title' => 'Halaman Kontak',
            'transactions' => $transactions,
        ]);
    }

    public function profile(): View
    {
        if (auth()->user() != null && auth()->user()->role == 'reseller') {
            $transactions = Transaction::whereRaw('created_at <> updated_at')->where('status', 2)->get();
        } else {
            $transactions = [];
        }

        return view('homepage.profile', [
            'title' => 'Halaman Profil',
            'profile' => $this->customer->findByUserId(auth()->user()->id),
            'transactions' => $transactions,
        ]);
    }

    public function orderCompleted(): View
    {
        if (auth()->user() != null && auth()->user()->role == 'reseller') {
            $transactions = Transaction::whereRaw('created_at <> updated_at')->where('status', 2)->get();
        } else {
            $transactions = [];
        }

        return view('homepage.order-completed', [
            'title' => 'Halaman Order Berhasil',
            'transactions' => $transactions,
        ]);
    }
}
