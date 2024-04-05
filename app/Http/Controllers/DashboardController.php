<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Repositories\PackageRepositories;
use App\Repositories\ProductRepositories;
use App\Repositories\ResellerRepositories;
use App\Repositories\TransactionRepositories;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct(
        protected readonly ProductRepositories $product,
        protected readonly PackageRepositories $package,
        protected readonly ResellerRepositories $reseller,
        protected readonly TransactionRepositories $transaction,
    ) {
    }

    public function index(): View
    {
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
            return view('dashboard.index', [
                'title' => 'Halaman Dashboard',
                'total_poin' => $this->reseller->findByUserId(auth()->user()->id)->poin,
                'total_transaction' => count($this->transaction->findAllByReseller(auth()->user()->id)),
                'total_product_sold' => $this->transaction->findTotalProductSoldByReseller(auth()->user()->id),
                'total_revenue' => $this->transaction->findTotalRevenueByReseller(auth()->user()->id),
                'graphic_day' => $this->transaction->filterDayByReseller(auth()->user()->id),
                'graphic_week' => $this->transaction->filterWeekByReseller(auth()->user()->id),
                'graphic_month' => $this->transaction->filterMonthByReseller(auth()->user()->id),
                'products' => $this->product->findAll(),
                'total_acumulation' => $this->transaction->totalAculmulationProduct(auth()->user()->id),
            ]);
        }
    }
}
