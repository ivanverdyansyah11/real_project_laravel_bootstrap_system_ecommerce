<?php

namespace App\Repositories;

use App\Models\Admin;
use App\Models\User;

class AdminRepositories
{
    public function __construct(
        protected readonly User $user,
        protected readonly Admin $admin,
    ) {}

    public function findAll()
    {
        return $this->admin->with(['user'])->latest()->get();
    }

    public function findAllPaginate()
    {
        return $this->admin->with(['user'])->latest()->get();
    }

    public function findById(int $admin_id): admin
    {
        return $this->admin->with(['user'])->where('id', $admin_id)->first();
    }
}
