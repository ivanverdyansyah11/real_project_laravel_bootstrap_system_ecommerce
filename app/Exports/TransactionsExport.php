<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;

class TransactionsExport implements FromCollection
{
    public function collection()
    {
        $transactions = Transaction::with(['product'])->whereIn('status', [0, 1])->get();
        $transactionArray = [];
        $transactionArray[] = ['INVOIS', 'NAMA PRODUK', 'JUMLAH', 'SATUAN', 'TOTAL'];
        foreach ($transactions as $transaction) {
            $transactionPrice = $transaction->total_per_product != null ? $transaction->total_per_product : $transaction->total;
            $transactionArray[] = [$transaction->invois, $transaction->product->name, $transaction->quantity, $transaction->price_per_product, $transactionPrice];
        }
        return collect($transactionArray);
    }
}
