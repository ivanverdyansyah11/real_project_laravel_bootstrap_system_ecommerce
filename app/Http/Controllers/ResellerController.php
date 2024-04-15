<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResellerRequest;
use App\Http\Requests\UpdateResellerRequest;
use App\Models\Reseller;
use App\Repositories\ResellerRepositories;
use App\Repositories\TransactionRepositories;
use Illuminate\Contracts\View\View;

class ResellerController extends Controller
{
    public function __construct(
        protected readonly ResellerRepositories $reseller,
        protected readonly TransactionRepositories $transaction,
    ) {
    }

    public function index()
    {
        return view('reseller.index', [
            'title' => 'Halaman Reseller',
            'resellers' => $this->reseller->findAll(),
            'transaction_pendings' => $this->transaction->findAllWherePending(),
            'transaction_payments' => $this->transaction->findAllWherePayment(),
        ]);
    }

    public function show(Reseller $reseller): View
    {
        return view('reseller.detail', [
            'title' => 'Halaman Detail Reseller',
            'reseller' => $this->reseller->findById($reseller->id),
            'transaction_pendings' => $this->transaction->findAllWherePending(),
            'transaction_payments' => $this->transaction->findAllWherePayment(),
        ]);
    }

    public function approved(int $id)
    {
        try {
            $this->reseller->approved($id);
            return redirect()->route('reseller.index')->with('success', 'Berhasil menyetujui reseller');
        } catch (\Exception $e) {
            return redirect()->route('reseller.create')->with('error', 'Gagal menyetujui reseller');
        }
    }

    public function create(): View
    {
        return view('reseller.add', [
            'title' => 'Halaman Tambah Reseller',
            'transaction_pendings' => $this->transaction->findAllWherePending(),
            'transaction_payments' => $this->transaction->findAllWherePayment(),
        ]);
    }

    public function store(StoreResellerRequest $request)
    {
        try {
            $this->reseller->store($request->validated());
            return redirect()->route('reseller.index')->with('success', 'Berhasil membuat reseller baru');
        } catch (\Exception $e) {
            return redirect()->route('reseller.create')->with('error', 'Gagal membuat reseller baru');
        }
    }

    public function edit(Reseller $reseller): View
    {
        return view('reseller.edit', [
            'title' => 'Halaman Edit Reseller',
            'reseller' => $this->reseller->findById($reseller->id),
            'transaction_pendings' => $this->transaction->findAllWherePending(),
            'transaction_payments' => $this->transaction->findAllWherePayment(),
        ]);
    }

    public function update(UpdateResellerRequest $request, Reseller $reseller)
    {
        try {
            $this->reseller->update($request->validated(), $reseller);
            return redirect()->route('reseller.index')->with('success', 'Berhasil edit reseller');
        } catch (\Exception $e) {
            return redirect()->route('reseller.edit')->with('error', 'Gagal edit reseller');
        }
    }

    public function destroy(Reseller $reseller)
    {
        try {
            $this->reseller->delete($reseller);
            return redirect(route('reseller.index'))->with('success', 'Berhasil hapus reseller!');
        } catch (\Exception $e) {
            return redirect(route('reseller.index'))->with('failed', 'Gagal hapus reseller!');
        }
    }
}
