<?php

namespace App\Repositories;

use App\Models\ReportProduct;

class ReportProductRepositories
{
    public function __construct(
        protected readonly ReportProduct $reportProduct,
    ) {
    }

    public function findAll()
    {
        return $this->reportProduct->with('product')->latest()->get();
    }

    public function findAllPaginate()
    {
        return $this->reportProduct->with('product')->latest()->get();
    }

    public function findById(int $id): ReportProduct
    {
        return $this->reportProduct->with('product')->where('id', $id)->first();
    }
}
