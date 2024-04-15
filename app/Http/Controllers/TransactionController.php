<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateShippingRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Transaction;
use App\Repositories\CartRepositories;
use App\Repositories\PackageRepositories;
use App\Repositories\ProductRepositories;
use App\Repositories\TransactionRepositories;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route as FacadesRoute;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    public function __construct(
        protected readonly TransactionRepositories $transaction,
        protected readonly ProductRepositories $product,
        protected readonly PackageRepositories $package,
        protected readonly CartRepositories $cart,
    ) {
    }

    public function index(Request $request)
    {
        if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin') {
            if (FacadesRoute::is('transaction-pending')) {
                if ($request->has('start_date') && $request->has('end_date')) {
                    $transactions = $this->transaction->findAllWherePendingFilter($request);
                    $request = $request->all();
                } else {
                    $transactions = $this->transaction->findAllWherePending();
                    $request = null;
                }

                return view('transaction-pending.index', [
                    'title' => 'Halaman Transaksi Pesanan',
                    'transactions' => $transactions,
                    'request' => $request,
                    'transaction_pendings' => $this->transaction->findAllWherePending(),
                    'transaction_payments' => $this->transaction->findAllWherePayment(),
                ]);
            } elseif (FacadesRoute::is('transaction-payment')) {
                if ($request->has('start_date') && $request->has('end_date')) {
                    $transactions = $this->transaction->findAllWherePaymentFilter($request);
                    $request = $request->all();
                } else {
                    $transactions = $this->transaction->findAllWherePayment();
                    $request = null;
                }

                foreach ($transactions as $transaction) {
                    $transactionDayLimit = Carbon::parse($transaction->updated_at)->addDay();
                    $product = $this->product->findById($transaction->products_id);
                    if (Carbon::now() >= $transactionDayLimit || $transaction->quantity > $product->stock) {
                        $this->cart->findByIdAndInvois($transaction->invois)->delete();
                        $transaction->delete();
                    }
                }

                return view('transaction-payment.index', [
                    'title' => 'Halaman Transaksi Menunggu Pembayaran',
                    'transactions' => $transactions,
                    'request' => $request,
                    'transaction_pendings' => $this->transaction->findAllWherePending(),
                    'transaction_payments' => $this->transaction->findAllWherePayment(),
                ]);
            } elseif (FacadesRoute::is('transaction-finish')) {
                if ($request->has('start_date') && $request->has('end_date')) {
                    $transactions = $this->transaction->findAllWhereFinishFilter($request);
                    $request = $request->all();
                } else {
                    $transactions = $this->transaction->findAllWhereFinish();
                    $request = null;
                }
                return view('transaction-finish.index', [
                    'title' => 'Halaman Transaksi Selesai',
                    'transactions' => $transactions,
                    'request' => $request,
                    'transaction_pendings' => $this->transaction->findAllWherePending(),
                    'transaction_payments' => $this->transaction->findAllWherePayment(),
                ]);
            } elseif (FacadesRoute::is('report-transaction')) {
                if ($request->has('start_date') && $request->has('end_date')) {
                    $transactions = $this->transaction->findAllFilter($request);
                    $request = $request->all();
                } else {
                    $transactions = $this->transaction->findAll();
                    $request = null;
                }

                return view('report-transaction.index', [
                    'title' => 'Halaman Rekap Transaksi',
                    'transactions' => $transactions,
                    'request' => $request,
                    'transaction_pendings' => $this->transaction->findAllWherePending(),
                    'transaction_payments' => $this->transaction->findAllWherePayment(),
                ]);
            }
        } else {
            return view('report-transaction.index-reseller', [
                'title' => 'Halaman Rekap Transaksi',
                'transactionAll' => $this->transaction->findAllByReseller(auth()->user()->id),
                'transactionPending' => $this->transaction->findAllWherePendingByReseller(auth()->user()->id),
                'transactionFinish' => $this->transaction->findAllWhereFinishByReseller(auth()->user()->id),
                'transactionConfirmation' => $this->transaction->findAllWherePaymentByReseller(auth()->user()->id),
                'transaction_pendings' => $this->transaction->findAllWherePending(),
                'transaction_payments' => $this->transaction->findAllWherePayment(),
            ]);
        }
    }

    public function show(Transaction $transaction): View
    {
        $transaction = $this->transaction->findById($transaction->id);
        $transaction = $this->transaction->findByInvois($transaction->invois);
        $packages = [];
        foreach ($transaction as $i => $transac) {
            $packages[] = $this->package->findWhereProduct($transac->quantity, $transac->products_id);
        }
        return view('report-transaction.detail', [
            'title' => 'Halaman Detail Transaksi',
            'transactions' => $transaction,
            'packages' => $packages,
            'transaction_pendings' => $this->transaction->findAllWherePending(),
            'transaction_payments' => $this->transaction->findAllWherePayment(),
        ]);
    }

    public function exportExcel()
    {
        return Excel::download(new TransactionsExport, 'transactions.xlsx');
    }

    public function export(int $transaction_id)
    {
        $transaction = $this->transaction->findById($transaction_id);
        $transaction = $this->transaction->findByInvois($transaction->invois);
        $packages = [];
        foreach ($transaction as $i => $transac) {
            $packages[] = $this->package->findWhereProduct($transac->quantity, $transac->products_id);
        }

        $data = [
            'transactions' => $transaction,
            'packages' => $packages,
        ];

        $pdf = PDF::loadView('report-transaction.export.index', $data)->setPaper('a4', 'landscape');
        return $pdf->stream();
    }

    public function getProduct(int $id): JsonResponse
    {
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

    public function getPackage($quantity, $id): JsonResponse
    {
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

    public function getPackageAll($id)
    {
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

    public function store(StoreTransactionRequest $request): RedirectResponse
    {
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

    public function edit(Transaction $transaction): View
    {
        $transaction = $this->transaction->findById($transaction->id);
        return view('report-transaction.edit', [
            'title' => 'Halaman Edit Transaksi',
            'transactions' => $this->transaction->findByInvois($transaction->invois),
            'transactionId' => $transaction->id,
            'transaction_pendings' => $this->transaction->findAllWherePending(),
            'transaction_payments' => $this->transaction->findAllWherePayment(),
        ]);
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction): RedirectResponse
    {
        try {
            $this->transaction->update($request->validated(), $transaction);
            return redirect(route('report-transaction'))->with('success', 'Berhasil edit transaksi baru!');
        } catch (\Exception $e) {
            return redirect(route('report-transaction'))->with('failed', 'Gagal edit transaksi baru!');
        }
    }

    public function approved($id): RedirectResponse
    {
        try {
            $this->transaction->approved($id);
            return redirect(route('report-transaction'))->with('success', 'Berhasil menyetujui transaksi!');
        } catch (\Exception $e) {
            return redirect(route('report-transaction'))->with('failed', 'Gagal menyetujui transaksi!');
        }
    }

    public function approvedShipping($id, UpdateShippingRequest $request): RedirectResponse
    {
        try {
            $this->transaction->approvedShipping($id, $request->validated());
            return back()->with('success', 'Berhasil menyetujui transaksi!');
        } catch (\Exception $e) {
            return back()->with('failed', 'Gagal menyetujui transaksi!');
        }
    }
}
