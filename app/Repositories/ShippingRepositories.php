<?php

namespace App\Repositories;

use App\Models\Shipping;

class ShippingRepositories
{
    public function __construct(
        protected readonly Shipping $shipping
    ) {
    }

    public function findAll()
    {
        return $this->shipping->latest()->get();
    }

    public function findFirst()
    {
        return $this->shipping->latest()->first();
    }

    public function findAllPaginate()
    {
        return $this->shipping->latest()->get();
    }

    public function findById(int $shipping_id): Shipping
    {
        return $this->shipping->where('id', $shipping_id)->first();
    }

    public function update($request): bool
    {
        $request['shipping_price'] = str_replace('Rp. ', '', $request['shipping_price']);
        $request['shipping_price'] = (int) str_replace('.', '', $request['shipping_price']);
        $shipping = $this->findFirst();
        return $shipping->update($request);
    }
}
