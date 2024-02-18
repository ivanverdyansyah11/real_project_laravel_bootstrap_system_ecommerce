<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index() : View {
        return view('transaction.index', [
            'title' => 'Transaction Page',
        ]);
    }
}
