<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCashierRequest;
use App\Http\Requests\StorePaymentCashierRequest;
use App\Models\Cashier;
use App\Repositories\AdminRepositories;
use App\Repositories\CashierRepositories;
use App\Repositories\PackageRepositories;
use App\Repositories\PaymentRepositories;
use App\Repositories\ProductRepositories;
use App\Repositories\ResellerRepositories;
use App\Repositories\TransactionRepositories;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use PDF;

class CashierController extends Controller
{
    public function __construct(
        protected readonly ResellerRepositories $reseller,
        protected readonly ProductRepositories $product,
        protected readonly CashierRepositories $cashier,
        protected readonly PaymentRepositories $payment,
        protected readonly TransactionRepositories $transaction,
        protected readonly AdminRepositories $admin,
        protected readonly PackageRepositories $package,
    ) {
    }

    public function index(): View
    {
        return view('cashier.index', [
            'title' => 'Halaman Kasir',
            'total_reseller_unactive' => count($this->reseller->findAllWhereStatus()),
            'cashiers' => $this->cashier->findAll(),
            'transaction_pendings' => $this->transaction->findAllWherePending(),
            'transaction_payments' => $this->transaction->findAllWherePayment(),
        ]);
    }

    public function show(int $products_id): JsonResponse
    {
        try {
            return response()->json([
                'status' => 'success',
                'data' => $this->product->findById($products_id),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal untuk mengambil data dari produk dengan ID ' . $products_id,
            ], 500);
        }
    }

    public function create(): View
    {
        return view('cashier.create', [
            'title' => 'Halaman Kasir',
            'total_reseller_unactive' => count($this->reseller->findAllWhereStatus()),
            'products' => $this->product->findAll(),
            'cashiers' => $this->cashier->findAll(),
            'transaction_pendings' => $this->transaction->findAllWherePending(),
            'transaction_payments' => $this->transaction->findAllWherePayment(),
        ]);
    }

    public function store(StoreCashierRequest $request): RedirectResponse
    {
        try {
            $this->cashier->store($request->validated());
            return redirect(route('cashier.index'))->with('success', 'Berhasil menambahkan produk baru!');
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect()->back()->with('failed', 'Gagal menambahkan produk baru!');
        }
    }

    public function createPayment(): View
    {
        return view('cashier.payment', [
            'title' => 'Halaman Pembayaran Kasir',
            'total_reseller_unactive' => count($this->reseller->findAllWhereStatus()),
            'cashiers' => $this->cashier->findAll(),
            'payments' => $this->payment->findAll(),
            'profile' => $this->admin->findById(auth()->user()->admin->id),
            'transaction_pendings' => $this->transaction->findAllWherePending(),
            'transaction_payments' => $this->transaction->findAllWherePayment(),
        ]);
    }

    public function storePayment(StorePaymentCashierRequest $request)
    {
        try {
            $this->cashier->storePayment($request->validated());
            $transaction = $this->transaction->findLatest();
            return redirect(route('transaction.show', $transaction->id))->with('success', 'Berhasil melakukan pembayaran transaksi!');
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect(route('cashier.index'))->with('failed', 'Gagal melakukan pembayaran transaksi!');
        }
    }

    public function destroy(Cashier $cashier): RedirectResponse
    {
        try {
            $this->cashier->delete($cashier);
            return redirect(route('cashier.index'))->with('success', 'Berhasil hapus produk!');
        } catch (\Exception $e) {
            return redirect(route('cashier.index'))->with('failed', 'Gagal hapus produk!');
        }
    }
}
