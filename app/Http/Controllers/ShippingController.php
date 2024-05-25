<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateShippingLocationRequest;
use App\Http\Requests\UpdateShippingRequest;
use App\Models\Shipping;
use App\Repositories\ResellerRepositories;
use App\Repositories\ShippingRepositories;
use App\Repositories\TransactionRepositories;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShippingController extends Controller
{
    public function __construct(
        protected readonly ResellerRepositories $reseller,
        protected readonly ShippingRepositories $shipping,
        protected readonly TransactionRepositories $transaction,
    ) {
    }

    public function index()
    {
        return view('shipping.index', [
            'title' => 'Halaman Shipping',
            'total_reseller_unactive' => count($this->reseller->findAllWhereStatus()),
            'shipping' => $this->shipping->findFirst(),
            'transaction_pendings' => $this->transaction->findAllWherePending(),
            'transaction_payments' => $this->transaction->findAllWherePayment(),
        ]);
    }

    public function show(): View
    {
        return view('shipping.detail', [
            'title' => 'Halaman Detail Shipping',
            'total_reseller_unactive' => count($this->reseller->findAllWhereStatus()),
            'shipping' => $this->shipping->findFirst(),
            'transaction_pendings' => $this->transaction->findAllWherePending(),
            'transaction_payments' => $this->transaction->findAllWherePayment(),
        ]);
    }

    public function edit(): View
    {
        return view('shipping.edit', [
            'title' => 'Halaman Edit Shipping',
            'total_reseller_unactive' => count($this->reseller->findAllWhereStatus()),
            'shipping' => $this->shipping->findFirst(),
            'transaction_pendings' => $this->transaction->findAllWherePending(),
            'transaction_payments' => $this->transaction->findAllWherePayment(),
        ]);
    }

    public function update(UpdateShippingLocationRequest $request)
    {
        try {
            $this->shipping->update($request->validated());
            return redirect()->route('shipping.index')->with('success', 'Berhasil edit shipping');
        } catch (\Exception $e) {
            return redirect()->route('shipping.edit')->with('error', 'Gagal edit shipping');
        }
    }
}
