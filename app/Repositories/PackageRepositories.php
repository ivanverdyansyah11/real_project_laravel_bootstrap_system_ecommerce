<?php

namespace App\Repositories;

use App\Models\Package;

class PackageRepositories
{
    public function __construct(
        protected readonly Package $package,
    ) {}

    public function findAll()
    {
        return $this->package->with('product')->latest()->get();
    }

    public function findAllPaginate()
    {
        return $this->package->with('product')->latest()->get();
    }

    public function findById(int $package_id): Package
    {
        return $this->package->with('product')->where('id', $package_id)->first();
    }

    public function findWhereProduct(int $quantity, int $id)
    {
        return $this->package->with('product')->where('products_id', $id)->where('quantity', '<=', $quantity)->orderBy('quantity', 'desc')->first();
    }

    public function findWhereProductId($id)
    {
        return $this->package->with('product')->whereIn('products_id', $id)->get();
    }

    public function store($request): Package
    {
        $request['selling_price'] = str_replace('Rp. ', '', $request['selling_price']);
        $request['selling_price'] = (int) str_replace('.', '', $request['selling_price']);
        return $this->package->create($request);
    }

    public function update($request, $package): bool
    {
        $request['selling_price'] = str_replace('Rp. ', '', $request['selling_price']);
        $request['selling_price'] = (int) str_replace('.', '', $request['selling_price']);
        return $package->update($request);
    }

    public function delete($package): bool
    {
        return $package->delete();
    }
}
