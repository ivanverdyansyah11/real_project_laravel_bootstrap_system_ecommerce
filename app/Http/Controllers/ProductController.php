<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() : View {
        return view('product.index', [
            'title' => 'Halaman Produk',
        ]);
    }
}
