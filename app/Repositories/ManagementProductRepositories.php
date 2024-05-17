<?php

namespace App\Repositories;

use App\Models\ManagementProduct;

class ManagementProductRepositories
{
    public function __construct(
        protected readonly ManagementProduct $managementProduct,
        protected readonly ProductRepositories $product,
    ) {
    }

    public function findAll()
    {
        return $this->managementProduct->latest()->get();
    }

    public function findAllPaginate()
    {
        return $this->managementProduct->latest()->get();
    }

    public function findById(int $managementProduct_id): ManagementProduct
    {
        return $this->managementProduct->where('id', $managementProduct_id)->first();
    }

    public function store($request): ManagementProduct
    {
        $product = $this->product->findById($request['products_id']);
        if ($request['type'] == 'add') {
            $product->update(['stock' => $product->stock + (int)$request['quantity']]);
            return $this->managementProduct->create($request);
        } elseif ($request['type'] == 'subtract') {
            $product->update(['stock' => $product->stock - (int)$request['quantity']]);
            return $this->managementProduct->create($request);
        }
    }

    public function update($request, $managementProduct): bool
    {
        $product = $this->product->findById($request['products_id']);
        if ($managementProduct->type == 'add') {
            $quantity = (int)$request['quantity'] - $managementProduct->quantity;
            $product->update(['stock' => $product->stock + $quantity]);
            return $managementProduct->update(['quantity' => (int)$request['quantity']]);
        } elseif ($managementProduct->type == 'subtract') {
            $quantity = (int)$request['quantity'] - $managementProduct->quantity;
            $product->update(['stock' => $product->stock - $quantity]);
            return $managementProduct->update(['quantity' => (int)$request['quantity']]);
        }
    }

    public function delete($managementProduct): bool
    {
        $product = $this->product->findById($managementProduct->products_id);
        if ($managementProduct->type == 'add') {
            $product->update(['stock' => $product->stock - $managementProduct->quantity]);
            return $managementProduct->delete();
        } elseif ($managementProduct->type == 'subtract') {
            $product->update(['stock' => $product->stock + $managementProduct->quantity]);
            return $managementProduct->delete();
        }
    }
}
