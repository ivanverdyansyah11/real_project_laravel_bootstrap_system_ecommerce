<?php

namespace App\Repositories;

use App\Models\Cashier;
use App\Models\Transaction;
use App\Utils\UploadFile;

class CashierRepositories
{
    public function __construct(
        protected readonly Cashier $cashier,
        protected readonly Transaction $transaction,
        protected readonly ProductRepositories $product,
        protected readonly PackageRepositories $package,
        protected readonly UploadFile $uploadFile,
    ) {
    }

    public function findAll()
    {
        return $this->cashier->with(['product'])->latest()->get();
    }

    public function findAllPaginate()
    {
        return $this->cashier->latest()->get();
    }

    public function findById(int $cashier_id): Cashier
    {
        return $this->cashier->where('id', $cashier_id)->first();
    }

    public function findByProductId(int $product_id)
    {
        return $this->cashier->where('products_id', $product_id)->first();
    }

    public function store($request)
    {
        $cashier = $this->findByProductId($request['products_id']);
        if ($cashier != null) {
            $request['quantity'] = $cashier->quantity + $request['quantity'];
            $package = $this->package->findWhereProduct($request['quantity'], $request['products_id']);
            if ($package != null) {
                $cashier->update(['selling_price' => $package->selling_price]);
            }
            return $cashier->update(['quantity' => $request['quantity']]);
        } else {
            return $this->cashier->create($request);
        }
    }

    public function storePayment($request)
    {
        $cashiers = $this->findAll();
        $request['invois'] = $cashiers[0]->invois;
        if (!empty($request['proof_of_payment'])) {
            $request['proof_of_payment'] = $this->uploadFile->uploadSingleFile($request['proof_of_payment'], "assets/images/transaction");
        }
        foreach ($cashiers as $cashier) {
            $request['products_id'] = $cashier->products_id;
            $request['quantity'] = $cashier->quantity;
            $request['price_per_product'] = $cashier->selling_price;
            $request['total_per_product'] = $cashier->selling_price * $cashier->quantity;
            $product = $this->product->findById($request['products_id']);
            $product->update(['stock' => $product->stock - $request['quantity']]);
            $this->transaction->create($request);
        }
        foreach ($cashiers as $cashier) {
            $cashier->delete();
        }
    }

    public function update($request, $cashier): bool
    {
        return $cashier->update($request);
    }

    public function delete($cashier): bool
    {
        return $cashier->delete();
    }
}
