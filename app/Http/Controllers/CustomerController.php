<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index() : View {
        return view('customer.index', [
            'title' => 'Halaman Pelanggan',
        ]);
    }
}
