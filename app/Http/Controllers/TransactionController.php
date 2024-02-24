<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route as FacadesRoute;

class TransactionController extends Controller
{
    public function index() : View {
        if (FacadesRoute::is('transaction-pending')) {
            return view('transaction-pending.index', [
                'title' => 'Halaman Transaksi Pesanan',
            ]);
        } elseif(FacadesRoute::is('transaction-finish')) {
            return view('transaction-finish.index', [
                'title' => 'Halaman Transaksi Selesai',
            ]);
        } else {
            return view('report-transaction.index', [
                'title' => 'Halaman Rekap Transaksi',
            ]);
        }
    }
}
