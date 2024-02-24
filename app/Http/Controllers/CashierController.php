<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index() : View {
        return view('cashier.index', [
            'title' => 'Halaman Kasir',
        ]);
    }
}
