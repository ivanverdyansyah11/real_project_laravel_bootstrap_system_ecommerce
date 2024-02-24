<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepositories
{
  public function __construct(
    protected readonly Customer $customer
  ) {}

  public function findAll()
  {
    return $this->customer->with(['user'])->latest()->get();
  }

  public function findAllPaginate()
  {
    return $this->customer->with(['user'])->latest()->paginate(10);
  }

  public function findById(int $customer_id): customer
  {
    return $this->customer->with(['user'])->where('id', $customer_id)->first();
  }

  public function store($request): customer
  {
    return $this->customer->create($request);
  }

  public function update($request, $customer): bool
  {
    return $customer->update($request);
  }

  public function delete($reseller): bool
  {
    return $reseller->delete();
  }
}