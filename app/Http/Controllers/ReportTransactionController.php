<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ReportTransactionController extends Controller
{
    public function index() : View {
        return view('report-transaction.index', [
            'title' => 'Report Transaction Page',
        ]);
    }
}
