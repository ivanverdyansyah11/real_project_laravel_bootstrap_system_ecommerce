<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRewardRequest;
use App\Models\TransactionReward;
use App\Repositories\ResellerRepositories;
use App\Repositories\RewardRepositories;
use App\Repositories\TransactionRewardRepositories;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TransactionRewardController extends Controller
{
    public function __construct(
        protected readonly TransactionRewardRepositories $transaction,
        protected readonly ResellerRepositories $reseller,
        protected readonly RewardRepositories $reward,
    ) {}

    public function index(): View {
        if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin') {
            return view('report-reward.index', [
                'title' => 'Halaman Rekap Poin',
                'transactions' => $this->transaction->findAll(),
            ]);
        } elseif(auth()->user()->role == 'reseller') {
            return view('report-reward.index', [
                'title' => 'Halaman Rekap Poin',
                'transactions' => $this->transaction->findAllByReseller(auth()->user()->id),
            ]);
        }
    }

    public function show(int $transaction_id): View {
        return view('report-reward.detail', [
            'title' => 'Halaman Detail Rekap Poin',
            'transaction' => $this->transaction->findById($transaction_id),
        ]);
    }

    public function store(StoreTransactionRewardRequest $request) : RedirectResponse {
        try {
            $reseller = $this->reseller->findByUserId($request['resellers_id']);
            $reward = $this->reward->findById($request['rewards_id']);
            if ($reseller->poin >= $reward->points_required) {
                $this->transaction->store($request->validated());
                return redirect(route('report-reward.index'))->with('success', 'Berhasil menambahkan transaksi penghargaan baru!');
            }
            return redirect(route('reward.index'))->with('failed', 'Poin tidak cukup, silahkan kumpulkan lebih lagi!');
        } catch (\Exception $e) {
            logger($e->getMessage());
            return redirect(route('reward.index'))->with('failed', 'Gagal menambahkan transaksi penghargaan baru!');
        }
    }
}
