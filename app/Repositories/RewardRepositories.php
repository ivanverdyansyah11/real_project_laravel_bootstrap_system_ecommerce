<?php

namespace App\Repositories;

use App\Models\Reward;

class RewardRepositories
{
    public function __construct(
        protected readonly Reward $reward
    ) {}

    public function findAll()
    {
        return $this->reward->latest()->get();
    }

    public function findAllPaginate()
    {
        return $this->reward->latest()->get();
    }

    public function findById(int $reward_id): reward
    {
        return $this->reward->where('id', $reward_id)->first();
    }

    public function store($request): reward
    {
        return $this->reward->create($request);
    }

    public function update($request, $reward): bool
    {
        return $reward->update($request);
    }

    public function delete($reward): bool
    {
        return $reward->delete();
    }
}
