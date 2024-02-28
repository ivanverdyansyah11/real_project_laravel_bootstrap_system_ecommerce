<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Utils\UploadFile;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class TransactionRepositories
{
    public function __construct(
        protected readonly Transaction $transaction,
        protected readonly ProductRepositories $product,
        protected readonly ResellerRepositories $reseller,
        protected readonly UploadFile $uploadFile,
    ) {}

    public function findAll()
    {
        return $this->transaction->latest()->get();
    }

    public function findAllWherePending()
    {
        return $this->transaction->where('status', 0)->latest()->get();
    }

    public function findAllWhereFinish()
    {
        return $this->transaction->where('status', 1)->latest()->get();
    }

    public function findTotalProductSold()
    {
        return $this->transaction->get()->sum('quantity');
    }

    public function findTotalRevenue()
    {
        return $this->transaction->get()->sum('total');
    }

    public function findAllPaginate()
    {
        return $this->transaction->latest()->get();
    }

    public function findById(int $transaction_id): Transaction
    {
        return $this->transaction->where('id', $transaction_id)->first();
    }

    public function filterWeek()
    {
        $startWeek = Carbon::now()->startOfWeek();
        $endWeek = Carbon::now()->endOfWeek();
        $transactionThisWeek = Transaction::whereBetween('created_at', [$startWeek, $endWeek])->get();
        $transactionPerDay = [
            'Monday' => [],
            'Tuesday' => [],
            'Wednesday' => [],
            'Thursday' => [],
            'Friday' => [],
            'Saturday' => [],
            'Sunday' => [],
        ];
        foreach ($transactionThisWeek as $transaction) {
            $transactionDay = Carbon::parse($transaction->created_at)->locale('en')->dayName;
            $transactionPerDay[$transactionDay][] = $transaction;
        }
        return $transactionPerDay;
    }

    public function filterMonth()
    {
        $thisYear = Carbon::now()->year;
        $transactionPerMonth = [
            'January' => [],
            'February' => [],
            'March' => [],
            'April' => [],
            'May' => [],
            'June' => [],
            'July' => [],
            'August' => [],
            'September' => [],
            'October' => [],
            'November' => [],
            'December' => [],
        ];
        for ($month = 1; $month <= 12; $month++) {
            $startMonth = Carbon::createFromDate($thisYear, $month, 1)->startOfMonth();
            $endMonth = Carbon::createFromDate($thisYear, $month, 1)->endOfMonth();
            $transactionThisMonth = Transaction::whereBetween('created_at', [$startMonth, $endMonth])->get();
            foreach ($transactionThisMonth as $transaction) {
                $transactionMonth = Carbon::parse($transaction->created_at)->locale('en')->monthName;
                $transactionPerMonth[$transactionMonth][] = $transaction;
            }
        }
        return $transactionPerMonth;
    }

    public function filterDay()
    {
        $waktuSaatIni = Carbon::now();
        $transaksiPerWaktu = [
            'Morning' => [],
            'Afternoon' => [],
            'Evening' => [],
            'Night' => [],
        ];
        $transaksiHariIni = Transaction::whereDate('created_at', $waktuSaatIni)->get();
        foreach ($transaksiHariIni as $transaksi) {
            $jamTransaksi = Carbon::parse($transaksi->created_at)->format('H:i:s');
            if ($jamTransaksi >= '05:00:00' && $jamTransaksi <= '10:59:59') {
                $transaksiPerWaktu['Morning'][] = $transaksi;
            } elseif ($jamTransaksi >= '11:00:00' && $jamTransaksi <= '14:59:59') {
                $transaksiPerWaktu['Afternoon'][] = $transaksi;
            } elseif ($jamTransaksi >= '15:00:00' && $jamTransaksi <= '17:59:59') {
                $transaksiPerWaktu['Evening'][] = $transaksi;
            } else {
                $transaksiPerWaktu['Night'][] = $transaksi;
            }
        }

        return $transaksiPerWaktu;
    }

    public function store($request): Transaction
    {
        if(isset($request['proof_of_payment'])) {
            $request['proof_of_payment'] = $this->uploadFile->uploadSingleFile($request['proof_of_payment'], "assets/images/transaction");
        }
        $product = $this->product->findById($request['products_id']);
        $request['invois'] = strtoupper(substr($product->name, 0, 3)) . '-' . rand();
        $request['stock'] = $product->stock - $request['quantity'];
        if ($request['resellers_id']) {
            $reseller = $this->reseller->findById($request['resellers_id']);
            $request['poin'] = $reseller->poin + $request['quantity'];
            $reseller->update(Arr::only($request, 'poin'));
        }
        $product->update(Arr::only($request, 'stock'));
        return $this->transaction->create(Arr::except($request, 'stock'));
    }

    public function update($request, $transaction): bool
    {
        dd($request);
        return $transaction->update($request);
    }
}
