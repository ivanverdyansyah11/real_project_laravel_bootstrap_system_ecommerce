<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreManagementProductRequest;
use App\Http\Requests\UpdateManagementProductRequest;
use App\Models\ManagementProduct;
use App\Repositories\ManagementProductRepositories;
use App\Repositories\ProductRepositories;
use App\Repositories\TransactionRepositories;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ManagementProductController extends Controller
{
    public function __construct(
        protected readonly ManagementProductRepositories $managementProduct,
        protected readonly ProductRepositories $product,
        protected readonly TransactionRepositories $transaction,
    ) {
    }

    public function index(): View
    {
        return view('management-product.index', [
            'title' => 'Halaman Managemen Produk',
            'products' => $this->product->findAll(),
            'management_products' => $this->managementProduct->findAllPaginate(),
            'transaction_pendings' => $this->transaction->findAllWherePending(),
            'transaction_payments' => $this->transaction->findAllWherePayment(),
        ]);
    }

    public function show(ManagementProduct $managementProduct): JsonResponse
    {
        try {
            return response()->json([
                'status' => 'success',
                'data' => $this->managementProduct->findById($managementProduct->id),
                'products' => $this->product->findAll(),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal untuk mengambil data dari managemen produk dengan ID ' . $managementProduct->id,
            ], 500);
        }
    }

    public function store(StoreManagementProductRequest $request): RedirectResponse
    {
        try {
            $this->managementProduct->store($request->validated());
            return redirect(route('management-product.index'))->with('success', 'Berhasil menambahkan managemen produk baru!');
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect(route('management-product.index'))->with('failed', 'Gagal menambahkan managemen produk baru!');
        }
    }

    public function update(UpdateManagementProductRequest $request, ManagementProduct $managementProduct): RedirectResponse
    {
        if ($managementProduct->quantity == $request['quantity']) {
            return redirect(route('management-product.index'))->with('failed', 'Tidak ada perubahan quantity!');
        }
        try {
            $this->managementProduct->update($request->validated(), $managementProduct);
            return redirect(route('management-product.index'))->with('success', 'Berhasil edit managemen produk!');
        } catch (\Exception $e) {
            return redirect(route('management-product.index'))->with('failed', 'Gagal edit managemen produk!');
        }
    }

    public function destroy(ManagementProduct $managementProduct): RedirectResponse
    {
        try {
            $this->managementProduct->delete($managementProduct);
            return redirect(route('management-product.index'))->with('success', 'Berhasil hapus managemen produk!');
        } catch (\Exception $e) {
            return redirect(route('management-product.index'))->with('failed', 'Gagal hapus managemen produk!');
        }
    }
}
