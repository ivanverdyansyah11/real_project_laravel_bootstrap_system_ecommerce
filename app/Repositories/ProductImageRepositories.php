<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductImage;
use App\Utils\UploadFile;
use Illuminate\Support\Facades\Route as FacadesRoute;

class ProductImageRepositories
{
    public function __construct(
        protected readonly ProductImage $productImage,
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
        if (FacadesRoute::is('thumbnail-image.create')) {
            $request['image'] = $this->uploadFile->uploadSingleFile($request['image'], "assets/images/product");
        }
        return $this->productImage->create($request);
    }

    public function update($id): bool
    {
        $productImageSingle = $this->findById($id);
        $productImages = $this->findAllWhereByproductId($productImageSingle->products_id);
        foreach ($productImages as $productImage) {
            $productImage->update(['status' => 0]);
        }
        $product = Product::where('id', $productImageSingle->products_id)->first();
        $product->update(['image' => $productImageSingle->image]);
        return $productImageSingle->update(['status' => 1]);
    }

    public function delete($id): bool
    {
        $productImage = $this->findById($id);
        $this->uploadFile->deleteExistFile("assets/images/product/" . $productImage->image);
        return $productImage->delete();
    }
}
