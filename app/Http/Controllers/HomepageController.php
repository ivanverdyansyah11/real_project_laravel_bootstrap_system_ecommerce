<?php

namespace App\Http\Controllers;

use App\Repositories\CustomerRepositories;
use App\Repositories\ProductRepositories;
use Illuminate\Contracts\View\View;

class HomepageController extends Controller
{
    public function __construct(
        protected readonly ProductRepositories $product,
        protected readonly CustomerRepositories $customer,
    ) {}

    public function index() : View {
        return view('homepage.index', [
            'title' => 'Halaman Beranda',
        ]);
    }

    public function products() : View {
        return view('homepage.products', [
            'title' => 'Halaman Produk',
            'products' => $this->product->findAll(),
        ]);
    }

    public function product(int $id) : View {
        return view('homepage.product', [
            'title' => 'Halaman Produk',
            'product' => $this->product->findById($id),
        ]);
    }

    public function testimonial() : View {
        return view('homepage.testimonial', [
            'title' => 'Halaman Kontak',
        ]);
    }

    public function contact() : View {
        return view('homepage.contact', [
            'title' => 'Halaman Kontak',
        ]);
    }

    public function profile() : View {
        return view('homepage.profile', [
            'title' => 'Halaman Profil',
            'profile' => $this->customer->findByUserId(auth()->user()->id),
        ]);
    }
}
