<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Transaction;
use App\Repositories\PackageRepositories;
use App\Repositories\ProductRepositories;
use App\Repositories\TransactionRepositories;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route as FacadesRoute;

class TransactionController extends Controller
{
    public function __construct(
        protected readonly TransactionRepositories $transaction,
        protected readonly ProductRepositories $product,
        protected readonly PackageRepositories $package,
    ) {}

    public function index() {
        if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin') {
            if (FacadesRoute::is('transaction-pending')) {
                return view('transaction-pending.index', [
                    'title' => 'Halaman Transaksi Pesanan',
                    'transactions' => $this->transaction->findAllWherePending(),
                ]);
            } elseif(FacadesRoute::is('transaction-finish')) {
                return view('transaction-finish.index', [
                    'title' => 'Halaman Transaksi Selesai',
                    'transactions' => $this->transaction->findAllWhereFinish(),
                ]);
            } elseif(FacadesRoute::is('report-transaction')) {
                return view('report-transaction.index', [
                    'title' => 'Halaman Rekap Transaksi',
                    'transactions' => $this->transaction->findAll(),
                ]);
            }
        } else {
            return view('report-transaction.index-reseller', [
                'title' => 'Halaman Rekap Transaksi',
                'transactionAll' => $this->transaction->findAllByReseller(auth()->user()->id),
                'transactionPending' => $this->transaction->findAllWherePendingByReseller(auth()->user()->id),
                'transactionFinish' => $this->transaction->findAllWhereFinishByReseller(auth()->user()->id),
            ]);
        }
    }

    public function show(Transaction $transaction) : View {
        return view('report-transaction.detail', [
            'title' => 'Halaman Detail Transaksi',
            'transaction' => $this->transaction->findById($transaction->id),
        ]);
    }

    public function getProduct(int $id) : JsonResponse {
        try {
            return response()->json([
                'status' => 'success',
                'data' => $this->product->findById($id),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal untuk mengambil data dari produk dengan ID ' . $id,
            ], 500);
        }
    }

    public function getPackage($quantity, $id) : JsonResponse {
        try {
            $package = $this->package->findWhereProduct($quantity, $id);
            return response()->json([
                'status' => 'success',
                'data' => $package,
            ]);
        } catch (\Exception $e) {
            logger($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal untuk mengambil data dari produk dengan Kuantitas ' . $quantity,
            ], 500);
        }
    }

    public function getPackageAll($id) {
        $productIdSelect = explode('+', $id);
        try {
            $package = $this->package->findWhereProductId($productIdSelect);
            return response()->json([
                'status' => 'success',
                'data' => $package,
            ]);
        } catch (\Exception $e) {
            logger($e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal untuk mengambil data dari produk dengan ID ' . $id,
            ], 500);
        }
    }

    public function store(StoreTransactionRequest $request) : RedirectResponse {
        try {
            $this->transaction->store($request->validated());
            if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin') {
                return redirect(route('transaction-finish'))->with('success', 'Berhasil menambahkan transaksi baru!');
            } else {
                return redirect(route('report-transaction'))->with('success', 'Berhasil menambahkan transaksi baru!');
            }
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect(route('cashier.index'))->with('failed', 'Gagal menambahkan transaksi baru!');
        }
    }

    public function edit(Transaction $transaction) : View {
        return view('report-transaction.edit', [
            'title' => 'Halaman Edit Transaksi',
            'transaction' => $this->transaction->findById($transaction->id),
        ]);
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction) : RedirectResponse {
        try {
            $this->transaction->update($request->validated(), $transaction);
            return redirect(route('report-transaction'))->with('success', 'Berhasil edit transaksi baru!');
        } catch (\Exception $e) {
            return redirect(route('report-transaction'))->with('failed', 'Gagal edit transaksi baru!');
        }
    }

    public function approved($id) : RedirectResponse {
        try {
            $this->transaction->approved($id);
            return redirect(route('report-transaction'))->with('success', 'Berhasil menyetujui transaksi!');
        } catch (\Exception $e) {
            return redirect(route('report-transaction'))->with('failed', 'Gagal menyetujui transaksi!');
        }
    }
}
