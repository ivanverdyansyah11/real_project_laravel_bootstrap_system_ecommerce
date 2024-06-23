<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Utils\UploadFile;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class TransactionRepositories
{
    public function __construct(
        protected readonly Transaction $transaction,
        protected readonly ProductRepositories $product,
        protected readonly ResellerRepositories $reseller,
        protected readonly UploadFile $uploadFile,
    ) {
    }

    public function findAll()
    {
        return $this->transaction->with(['product'])->whereIn('status', [0, 1])->latest()->get();
    }

    public function findAllFilter(Request $request)
    {
        return $this->transaction->whereIn('status', [0, 1])->whereBetween('updated_at', [$request->start_date, $request->end_date])->get();
    }

    public function findAllWithNotification()
    {
        if (auth()->user()->role == 'admin') {
            return $this->transaction->where('status', 2)->where('shipping', 'ekspedisi')
                ->whereNotNull('resellers_id')
                ->get();
        } elseif (auth()->user()->role == 'reseller') {
            $reseller = $this->reseller->findByUserId(auth()->user()->id);
            return $this->transaction->where('status', 2)->where('shipping', 'ekspedisi')
                ->where('resellers_id', $reseller->id)
                ->whereNotNull('resellers_id')
                ->get();
        }
    }

    public function findAllByReseller(int $users_id)
    {
        $reseller = $this->reseller->findByUserId($users_id);
        return $this->transaction->where('resellers_id', $reseller->id)->get();
    }

    public function findAllWherePending()
    {
        return $this->transaction->where('status', 0)->latest()->get();
    }

    public function findAllWherePendingFilter(Request $request)
    {
        return $this->transaction->where('status', 0)->whereBetween('updated_at', [$request->start_date, $request->end_date])->latest()->get();
    }

    public function findAllWherePayment()
    {
        return $this->transaction->where('status', 2)->latest()->latest()->get();
    }

    public function findAllWherePaymentFilter(Request $request)
    {
        return $this->transaction->where('status', 2)->whereBetween('updated_at', [$request->start_date, $request->end_date])->latest()->get();
    }

    public function findAllWherePaymentByReseller(int $users_id)
    {
        $reseller = $this->reseller->findByUserId($users_id);
        return $this->transaction->where('resellers_id', $reseller->id)->where('status', 2)->latest()->get();
    }

    public function findAllWherePendingByReseller(int $users_id)
    {
        $reseller = $this->reseller->findByUserId($users_id);
        return $this->transaction->where('resellers_id', $reseller->id)->where('status', 0)->latest()->get();
    }

    public function findAllWhereFinish()
    {
        return $this->transaction->where('status', 1)->whereNot('shipping', 'cashier')->latest()->get();
    }

    public function findAllWhereFinishFilter(Request $request)
    {
        return $this->transaction->where('status', 1)->whereNot('shipping', 'cashier')->whereBetween('updated_at', [$request->start_date, $request->end_date])->latest()->get();
    }

    public function findAllWhereFinishByReseller(int $users_id)
    {
        $reseller = $this->reseller->findByUserId($users_id);
        return $this->transaction->where('resellers_id', $reseller->id)->where('status', 1)->latest()->get();
    }

    public function findTotalProductSold()
    {
        return $this->transaction->get()->sum('quantity');
    }

    public function findTotalProductSoldByReseller(int $users_id)
    {
        $reseller = $this->reseller->findByUserId($users_id);
        return $this->transaction->where('resellers_id', $reseller->id)->get()->sum('quantity');
    }

    public function findTotalRevenue()
    {
        return $this->transaction->get()->sum('total');
    }

    public function findTotalRevenueByReseller(int $users_id)
    {
        $reseller = $this->reseller->findByUserId($users_id);
        return $this->transaction->where('resellers_id', $reseller->id)->get()->sum('total');
    }

    public function findAllPaginate()
    {
        return $this->transaction->latest()->get();
    }

    public function findById(int $transaction_id): Transaction
    {
        return $this->transaction->where('id', $transaction_id)->first();
    }

    public function findLatest(): Transaction
    {
        return $this->transaction->latest()->first();
    }

    public function findByInvois($invois)
    {
        return $this->transaction->where('invois', $invois)->get();
    }

    public function filterDay()
    {
        $thisTime = Carbon::now();
        $transactionPerTime = [
            'Morning' => [],
            'Afternoon' => [],
            'Evening' => [],
            'Night' => [],
        ];
        $transactionThisTime = Transaction::whereDate('created_at', $thisTime)->get();
        foreach ($transactionThisTime as $transaction) {
            $hourTransaction = Carbon::parse($transaction->created_at)->format('H:i:s');
            if ($hourTransaction >= '05:00:00' && $hourTransaction <= '10:59:59') {
                $transactionPerTime['Morning'][] = $transaction;
            } elseif ($hourTransaction >= '11:00:00' && $hourTransaction <= '14:59:59') {
                $transactionPerTime['Afternoon'][] = $transaction;
            } elseif ($hourTransaction >= '15:00:00' && $hourTransaction <= '17:59:59') {
                $transactionPerTime['Evening'][] = $transaction;
            } else {
                $transactionPerTime['Night'][] = $transaction;
            }
        }
        return $transactionPerTime;
    }

    public function filterDayByReseller(int $users_id)
    {
        $reseller = $this->reseller->findByUserId($users_id);
        $thisTime = Carbon::now();
        $transactionPerTime = [
            'Morning' => [],
            'Afternoon' => [],
            'Evening' => [],
            'Night' => [],
        ];
        $transactionThisTime = Transaction::where('resellers_id', $reseller->id)->whereDate('created_at', $thisTime)->get();
        foreach ($transactionThisTime as $transaction) {
            $hourTransaction = Carbon::parse($transaction->created_at)->format('H:i:s');
            if ($hourTransaction >= '05:00:00' && $hourTransaction <= '10:59:59') {
                $transactionPerTime['Morning'][] = $transaction;
            } elseif ($hourTransaction >= '11:00:00' && $hourTransaction <= '14:59:59') {
                $transactionPerTime['Afternoon'][] = $transaction;
            } elseif ($hourTransaction >= '15:00:00' && $hourTransaction <= '17:59:59') {
                $transactionPerTime['Evening'][] = $transaction;
            } else {
                $transactionPerTime['Night'][] = $transaction;
            }
        }
        return $transactionPerTime;
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

    public function filterWeekByReseller(int $users_id)
    {
        $reseller = $this->reseller->findByUserId($users_id);
        $startWeek = Carbon::now()->startOfWeek();
        $endWeek = Carbon::now()->endOfWeek();
        $transactionThisWeek = Transaction::where('resellers_id', $reseller->id)->whereBetween('created_at', [$startWeek, $endWeek])->get();
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

    public function filterMonthByReseller(int $users_id)
    {
        $reseller = $this->reseller->findByUserId($users_id);
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
            $transactionThisMonth = Transaction::where('resellers_id', $reseller->id)->whereBetween('created_at', [$startMonth, $endMonth])->get();
            foreach ($transactionThisMonth as $transaction) {
                $transactionMonth = Carbon::parse($transaction->created_at)->locale('en')->monthName;
                $transactionPerMonth[$transactionMonth][] = $transaction;
            }
        }
        return $transactionPerMonth;
    }

    public function totalAculmulationProduct(int $user_id)
    {
        $reseller = $this->reseller->findByUserId($user_id);
        return $this->transaction->select('transactions.products_id', 'products.name', DB::raw('SUM(transactions.quantity) as total_quantity'))
            ->join('products', 'transactions.products_id', '=', 'products.id')
            ->where('transactions.resellers_id', $reseller->id)
            ->groupBy('transactions.products_id', 'products.name')
            ->get();
    }

    public function store($request): Transaction
    {
        if (isset($request['proof_of_payment'])) {
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
        if (isset($request["proof_of_payment"])) {
            $request['proof_of_payment'] = $this->uploadFile->uploadSingleFile($request['proof_of_payment'], 'assets/images/transaction');
        }
        return $transaction->update($request);
    }

    public function approved(int $id): bool
    {
        $transaction = $this->findById($id);
        $transactions = $this->findByInvois($transaction->invois);
        $request['status'] = 1;
        foreach ($transactions as $transaction) {
            $transaction->update($request);
        }
        return true;
    }

    public function approvedShipping(int $id, $request): bool
    {
        if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin') {
            $transaction = $this->findById($id);
            $transactions = $this->findByInvois($transaction->invois);
            foreach ($transactions as $transaction) {
                $transaction->update($request);
            }
            return true;
        } elseif (auth()->user()->role == 'reseller') {
            $transaction = $this->findById($id);
            return $transaction->update($request);
        }
    }
}
