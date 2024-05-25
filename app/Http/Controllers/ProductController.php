<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Repositories\CategoryRepositories;
use App\Repositories\ProductImageRepositories;
use App\Repositories\ProductRepositories;
use App\Repositories\ResellerRepositories;
use App\Repositories\TransactionRepositories;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected readonly ResellerRepositories $reseller,
        protected readonly ProductRepositories $product,
        protected readonly ProductImageRepositories $productImage,
        protected readonly CategoryRepositories $category,
        protected readonly TransactionRepositories $transaction,
    ) {
    }

    public function index(): View
    {
        return view('product.index', [
            'title' => 'Halaman Produk',
            'total_reseller_unactive' => count($this->reseller->findAllWhereStatus()),
            'products' => $this->product->findAllPaginate(),
            'product_limits' => $this->product->findAllLimit(),
            'transaction_pendings' => $this->transaction->findAllWherePending(),
            'transaction_payments' => $this->transaction->findAllWherePayment(),
        ]);
    }

    public function show(Product $product): View
    {
        return view('product.detail', [
            'title' => 'Halaman Detail Produk',
            'total_reseller_unactive' => count($this->reseller->findAllWhereStatus()),
            'product' => $this->product->findById($product->id),
            'product_images' => $this->productImage->findAllWhereByproductId($product->id),
            'transaction_pendings' => $this->transaction->findAllWherePending(),
            'transaction_payments' => $this->transaction->findAllWherePayment(),
        ]);
    }

    public function create(): View
    {
        return view('product.add', [
            'title' => 'Halaman Tambah Produk',
            'total_reseller_unactive' => count($this->reseller->findAllWhereStatus()),
            'categories' => $this->category->findAll(),
            'transaction_pendings' => $this->transaction->findAllWherePending(),
            'transaction_payments' => $this->transaction->findAllWherePayment(),
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $this->product->store($request->validated());
            return redirect()->route('product.index')->with('success', 'Berhasil membuat produk baru');
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect()->route('product.create')->with('error', 'Gagal membuat produk baru');
        }
    }

    public function edit(Product $product): View
    {
        return view('product.edit', [
            'title' => 'Halaman Edit Produk',
            'total_reseller_unactive' => count($this->reseller->findAllWhereStatus()),
            'product' => $this->product->findById($product->id),
            'categories' => $this->category->findAll(),
            'product_images' => $this->productImage->findAllWhereByproductId($product->id),
            'transaction_pendings' => $this->transaction->findAllWherePending(),
            'transaction_payments' => $this->transaction->findAllWherePayment(),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $this->product->update($request->validated(), $product);
            return redirect()->route('product.index')->with('success', 'Berhasil edit produk');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal edit produk');
        }
    }

    public function destroy(Product $product)
    {
        try {
            $this->product->delete($product);
            return redirect(route('product.index'))->with('success', 'Berhasil hapus produk!');
        } catch (\Exception $e) {
            return redirect(route('product.index'))->with('failed', 'Gagal hapus produk!');
        }
    }
}
