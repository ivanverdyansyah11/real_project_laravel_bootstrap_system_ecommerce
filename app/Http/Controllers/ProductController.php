<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Repositories\CategoryRepositories;
use App\Repositories\ProductImageRepositories;
use App\Repositories\ProductRepositories;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected readonly ProductRepositories $product,
        protected readonly ProductImageRepositories $productImage,
        protected readonly CategoryRepositories $category,
    ) {
    }

    public function index(): View
    {
        return view('product.index', [
            'title' => 'Halaman Produk',
            'products' => $this->product->findAllPaginate(),
            'product_limits' => $this->product->findAllLimit(),
        ]);
    }

    public function show(Product $product): View
    {
        return view('product.detail', [
            'title' => 'Halaman Detail Produk',
            'product' => $this->product->findById($product->id),
            'product_images' => $this->productImage->findAllWhereByproductId($product->id),
        ]);
    }

    public function create(): View
    {
        return view('product.add', [
            'title' => 'Halaman Tambah Produk',
            'categories' => $this->category->findAll(),
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
            'product' => $this->product->findById($product->id),
            'categories' => $this->category->findAll(),
            'product_images' => $this->productImage->findAllWhereByproductId($product->id),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $this->product->update($request->validated(), $product);
            return redirect()->route('product.index')->with('success', 'Berhasil edit produk');
        } catch (\Exception $e) {
            return redirect()->route('product.edit')->with('error', 'Gagal edit produk');
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
