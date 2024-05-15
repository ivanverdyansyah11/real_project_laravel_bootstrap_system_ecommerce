<?php

namespace App\Http\Controllers;

use App\Repositories\ReportProductRepositories;
use App\Repositories\TransactionRepositories;
use Illuminate\View\View;

class ReportProductController extends Controller
{
    public function __construct(
        protected readonly ReportProductRepositories $reportProduct,
        protected readonly TransactionRepositories $transaction,
    ) {
    }

    public function index(): View
    {

        return view('report-product.index', [
            'title' => 'Halaman Laporan Produk',
            'report_products' => $this->reportProduct->findAllPaginate(),
            'transaction_pendings' => $this->transaction->findAllWherePending(),
            'transaction_payments' => $this->transaction->findAllWherePayment(),
        ]);
    }
}
