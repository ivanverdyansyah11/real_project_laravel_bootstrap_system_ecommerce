<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductImageRequest;
use App\Models\ProductImage;
use App\Repositories\ProductImageRepositories;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function __construct(
        protected readonly ProductImageRepositories $productImage,
    ) {
    }

    // public function store(StoreProductImageRequest $request)
    // {
    //     try {
    //         dd($request->validated());
    //         $this->productImage->store($request->validated());
    //         return redirect()->back()->with('success', 'Berhasil ganti thumbnail gambar produk!');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Gagal ganti thumbnail gambar produk!');
    //     }
    // }

    public function edit(int $id)
    {
        dd('123');
        return view('product.product-image.index', [
            'title' => 'Halaman Edit Thumbnail Produk',
            'product_images' => $this->productImage->findAllWhereByproductId($id),
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
