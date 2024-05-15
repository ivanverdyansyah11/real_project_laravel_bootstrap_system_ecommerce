<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ReportProduct;
use App\Utils\UploadFile;
use Illuminate\Support\Arr;

class ProductRepositories
{
    public function __construct(
        protected readonly Product $product,
        protected readonly ReportProduct $reportProduct,
        protected readonly ProductImage $productImage,
        protected readonly UploadFile $uploadFile,
        protected readonly ProductImageRepositories $productImageRepositories,
    ) {
    }

    public function findAll()
    {
        return $this->product->with('category')->latest()->get();
    }

    public function findWithAll()
    {
        return $this->productImage->with('product')->where('status', 1)->get();
    }

    public function findAllLimit()
    {
        return $this->product->with('category')->latest()->take(3)->get();
    }

    public function findAllPaginate()
    {
        return $this->product->with('category')->latest()->get();
    }

    public function findById(int $product_id): Product
    {
        return $this->product->with('category')->where('id', $product_id)->first();
    }

    public function findLatest(): Product
    {
        return $this->product->with('category')->latest()->first();
    }

    public function findWithById(int $product_id)
    {
        return $this->productImage->with('product')->where('products_id', $product_id)->where('status', 1)->first();
    }

    public function store($request): bool
    {
        $this->product->create(Arr::except($request, ['image']));
        $product = $this->findLatest();
        $this->reportProduct->create([
            'products_id' => $product->id,
            'stock' => $product->stock,
            'status' => 4,
        ]);
        foreach ($request['image'] as $image) {
            $request['products_id'] = $product->id;
            $request['image'] = $this->uploadFile->uploadSingleFile($image, "assets/images/product");
            $request['status'] = 0;
            $this->productImageRepositories->store(Arr::only($request, ['products_id', 'image', 'status']));
        }
        $productImage = ProductImage::where('products_id', $product->id)->first();
        $product->update(['image' => $productImage->image]);
        return $productImage->update(['status' => 1]);
    }

    public function update($request, $product): bool
    {
        if ((int)$request['stock'] == 0) {
            $status = 1;
        } elseif ((int)$request['stock'] > $product->stock) {
            $status = 3;
        } elseif ((int)$request['stock'] < $product->stock) {
            $status = 2;
        }
        $this->reportProduct->create([
            'products_id' => $product->id,
            'stock' => (int)$request['stock'],
            'status' => $status,
        ]);
        if (isset($request["image"])) {
            $this->uploadFile->deleteExistFile("assets/images/product/" . $product->image);
            $request['image'] = $this->uploadFile->uploadSingleFile($request['image'], 'assets/images/product');
        } else {
            $request['image'] = $product->image;
        }
        return $product->update($request);
    }

    public function delete($product): bool
    {
        $reportProducts = $this->reportProduct->where('products_id', $product->id)->get();
        foreach ($reportProducts as $reportProduct) {
            $reportProduct->delete();
        }
        $this->uploadFile->deleteExistFile("assets/images/product/" . $product->image);
        return $product->delete();
    }
}
