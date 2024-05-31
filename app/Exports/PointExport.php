<?php

namespace App\Exports;

use App\Models\Transaction;
use App\Models\TransactionReward;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;

class PointExport implements FromCollection
{
    public function collection()
    {
        $transactions = TransactionReward::with(['reward', 'reseller'])->get();
        $transactionArray = [];
        $transactionArray[] = ['PENGHARGAAN', 'POIN DIBUTUHKAN', 'NAMA RESELLER', 'NOMOR TELEPON RESELLER', 'ASAL RESELLER', 'TEMPAT & TANGGAL LAHIR', 'ALAMAT', 'TANGGAL PENUKARAN'];
        foreach ($transactions as $transaction) {
            $transactionArray[] = [$transaction->reward->name, $transaction->reward->points_required, $transaction->reseller->name, $transaction->reseller->number_phone, $transaction->reseller->origin, Str::headline($transaction->reseller->place_of_birth) . ', ' . $transaction->reseller->date_of_birth, $transaction->reseller->address, $transaction->created_at];
        }
        return collect($transactionArray);
    }
}
