<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductImageRequest;
use App\Repositories\ProductImageRepositories;
use App\Repositories\TransactionRepositories;
use App\Utils\UploadFile;

class ProductImageController extends Controller
{
    public function __construct(
        protected readonly ProductImageRepositories $productImage,
        protected readonly TransactionRepositories $transaction,
        protected readonly UploadFile $uploadFile,
    ) {
    }

    public function store(StoreProductImageRequest $request)
    {
        try {
            $this->productImage->store($request->validated());
            return redirect()->back()->with('success', 'Berhasil ganti thumbnail gambar produk!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal ganti thumbnail gambar produk!');
        }
    }

    public function edit(int $id)
    {
        return view('product.product-image.index', [
            'title' => 'Halaman Edit Thumbnail Produk',
            'product_images' => $this->productImage->findAllWhereByproductId($id),
            'transaction_pendings' => $this->transaction->findAllWherePending(),
            'transaction_payments' => $this->transaction->findAllWherePayment(),
        ]);
    }

    public function update(int $id)
    {
        try {
            $this->productImage->update($id);
            return redirect()->back()->with('success', 'Berhasil ganti thumbnail gambar produk!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal ganti thumbnail gambar produk!');
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->productImage->delete($id);
            return redirect()->back()->with('success', 'Berhasil hapus gambar produk!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal hapus gambar produk!');
        }
    }
}
