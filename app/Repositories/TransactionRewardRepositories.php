<?php

namespace App\Repositories;

use App\Models\TransactionReward;
use Illuminate\Support\Arr;

class TransactionRewardRepositories
{
    public function __construct(
        protected readonly TransactionReward $transaction,
        protected readonly ResellerRepositories $reseller,
        protected readonly RewardRepositories $reward,
    ) {}

    public function findAll()
    {
        return $this->transaction->with(['reward', 'reseller'])->latest()->get();
    }

    public function findAllByReseller(int $users_id)
    {
        $reseller = $this->reseller->findByUserId($users_id);
        return $this->transaction->with(['reward', 'reseller'])->where('resellers_id', $reseller->id)->get();
    }

    public function findAllPaginate()
    {
        return $this->transaction->with(['reward', 'reseller'])->latest()->get();
    }

    public function findById(int $transaction_id): TransactionReward
    {
        return $this->transaction->with(['reward', 'reseller'])->where('id', $transaction_id)->first();
    }

    public function store($request): TransactionReward
    {
        $reseller = $this->reseller->findByUserId($request['resellers_id']);
        $reward = $this->reward->findById($request['rewards_id']);
        $request['resellers_id'] = $reseller->id;
        $request['poin'] = $reseller->poin - $reward->points_required;
        $reseller->update(Arr::only($request, 'poin'));
        return $this->transaction->create(Arr::except($request, 'poin'));
    }

    public function update($request, $transaction): bool
    {
        return $transaction->update($request);
    }

    public function delete($transaction): bool
    {
        return $transaction->delete();
    }
}
