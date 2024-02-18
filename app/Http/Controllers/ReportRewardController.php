<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ReportRewardController extends Controller
{
    public function index() : View {
        return view('report-point.index', [
            'title' => 'Report Point Page',
        ]);
    }
}
