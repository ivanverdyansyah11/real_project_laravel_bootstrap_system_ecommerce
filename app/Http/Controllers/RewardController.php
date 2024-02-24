<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function index() : View {
        return view('reward.index', [
            'title' => 'Halaman Penghargaan',
        ]);
    }
}
