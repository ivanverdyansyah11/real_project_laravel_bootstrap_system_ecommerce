<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;

class TransactionsExport implements FromCollection
{
    public function collection()
    {
        $transactions = Transaction::with(['product', 'reseller', 'payment'])->where('status', 1)->get();
        $transactionArray = [];
        $transactionArray[] = ['INVOIS', 'NAMA PRODUK', 'NAMA RESELLER', 'PEMBAYARAN BANK', 'NAMA PEMBELI', 'JUMLAH', 'PENGIRIMAN', 'ALAMAT', 'SATUAN', 'TOTAL BAYAR', 'TOTAL DIBAYAR', 'TANGGAL & WAKTU TRANSAKSI'];
        foreach ($transactions as $transaction) {
            $transactionPrice = $transaction->total_per_product != null ? $transaction->total_per_product : $transaction->total;
            $transactionArray[] = [$transaction->invois, $transaction->product->name, $transaction->reseller ? $transaction->reseller->name : '-', $transaction->payment->bank_name, $transaction->buyers_name != null ? $transaction->buyers_name : '-', $transaction->quantity, $transaction->shipping, $transaction->address != null ? $transaction->address : '-', 'Rp. ' . number_format($transaction->price_per_product, 2, ',', '.'), 'Rp. ' . number_format($transactionPrice, 2, ',', '.'), 'Rp. ' . number_format($transaction->total_payment, 2, ',', '.'), $transaction->created_at];
        }
        return collect($transactionArray);
    }
}
