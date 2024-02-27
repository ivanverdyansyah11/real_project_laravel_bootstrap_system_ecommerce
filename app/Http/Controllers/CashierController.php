<?php

namespace App\Http\Controllers;

use App\Repositories\CustomerRepositories;
use App\Repositories\ProductRepositories;
use App\Repositories\ResellerRepositories;
use Illuminate\Contracts\View\View;

class CashierController extends Controller
{
    public function __construct(
        protected readonly CustomerRepositories $customer,
        protected readonly ResellerRepositories $reseller,
        protected readonly ProductRepositories $product,
    ) {}

    public function index() : View {
        return view('cashier.index', [
            'title' => 'Halaman Kasir',
            'customers' => $this->customer->findAll(),
            'resellers' => $this->reseller->findAll(),
            'products' => $this->product->findAll(),
        ]);
    }
}
