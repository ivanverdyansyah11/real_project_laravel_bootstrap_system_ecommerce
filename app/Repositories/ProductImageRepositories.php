<?php

namespace App\Repositories;

use App\Models\ProductImage;
use App\Utils\UploadFile;

class ProductImageRepositories
{
    public function __construct(
        protected readonly ProductImage $productImage,
        protected readonly ProductRepositories $product,
        protected readonly UploadFile $uploadFile,
    ) {
    }

    public function findAll()
    {
        return $this->productImage->latest()->get();
    }

    public function findAllWhereByproductId(int $product_id)
    {
        return $this->productImage->where('products_id', $product_id)->get();
    }

    public function findAllPaginate()
    {
        return $this->productImage->latest()->get();
    }

    public function findById(int $productImage_id): ProductImage
    {
        return $this->productImage->where('id', $productImage_id)->first();
    }

    public function store($request): ProductImage
    {
        $request['image'] = $this->uploadFile->uploadSingleFile($request['image'], "assets/images/product");
        $request['status'] = 0;
        return $this->productImage->create($request);
    }

    public function update($id): bool
    {
        $productImage = $this->findById($id);
        $productImages = $this->findAllWhereByproductId($productImage->products_id);
        foreach ($productImages as $productImage) {
            $productImage->update(['status' => 0]);
        }
        // $product = $this->product->findById($productImage->products_id);
        // $product->update(['image' => $productImage->image]);
        return $productImage->update(['status' => 1]);
    }

    public function delete($id): bool
    {
        $productImage = $this->findById($id);
        $this->uploadFile->deleteExistFile("assets/images/product/" . $productImage->image);
        return $productImage->delete();
    }
}
