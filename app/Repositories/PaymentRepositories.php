<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepositories
{
    public function __construct(
        protected readonly Payment $payment
    ) {
    }

    public function findAll()
    {
        return $this->payment->latest()->get();
    }

    public function findAllPaginate()
    {
        return $this->payment->latest()->get();
    }

    public function findById(int $payment_id): Payment
    {
        return $this->payment->where('id', $payment_id)->first();
    }

    public function store($request): Payment
    {
        return $this->payment->create($request);
    }

    public function update($request, $payment): bool
    {
        return $payment->update($request);
    }

    public function delete($payment): bool
    {
        return $payment->delete();
    }
}
