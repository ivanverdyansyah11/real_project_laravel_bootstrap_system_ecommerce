<?php

namespace App\Repositories;

use App\Models\Product;
use App\Utils\UploadFile;

class ProductRepositories
{
    public function __construct(
        protected readonly Product $product,
        protected readonly UploadFile $uploadFile,
    ) {}

    public function findAll()
    {
        return $this->product->with('category')->latest()->get();
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

    public function store($request): Product
    {
        $request['image'] = $this->uploadFile->uploadSingleFile($request['image'], "assets/images/product");
        return $this->product->create($request);
    }

    public function update($request, $product): bool
    {
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
        $this->uploadFile->deleteExistFile("assets/images/product/" . $product->image);
        return $product->delete();
    }
}
