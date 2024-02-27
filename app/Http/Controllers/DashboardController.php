<?php

namespace App\Http\Controllers;

use App\Repositories\PackageRepositories;
use App\Repositories\ProductRepositories;
use App\Repositories\TransactionRepositories;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected readonly ProductRepositories $product,
        protected readonly PackageRepositories $package,
        protected readonly TransactionRepositories $transaction,
    ) {}

    public function index() : View {
        if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin') {
            return view('dashboard.index', [
                'title' => 'Halaman Dashboard',
                'total_product' => count($this->product->findAll()),
                'total_package' => count($this->package->findAll()),
                'total_product_sold' => $this->transaction->findTotalProductSold(),
                'total_revenue' => $this->transaction->findTotalRevenue(),
                'graphic_day' => $this->transaction->filterDay(),
                'graphic_week' => $this->transaction->filterWeek(),
                'graphic_month' => $this->transaction->filterMonth(),
            ]);
        } else {
            return '123';
            // return view('dashboard.index', [
            //     'title' => 'Halaman Dashboard',
            //     'total_product' => count($this->product->findAll()),
            //     'total_package' => count($this->package->findAll()),
            //     'total_product_sold' => $this->transaction->findTotalProductSold(),
            //     'total_revenue' => $this->transaction->findTotalRevenue(),
            //     'graphic_day' => $this->transaction->filterDay(),
            //     'graphic_week' => $this->transaction->filterWeek(),
            //     'graphic_month' => $this->transaction->filterMonth(),
            // ]);
        }
    }
}
