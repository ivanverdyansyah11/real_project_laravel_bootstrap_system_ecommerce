<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route as FacadesRoute;

class TransactionRewardController extends Controller
{
    public function index(): View {
        return view('report-reward.index', [
            'title' => 'Halaman Rekap Poin',
        ]);
    }
}
