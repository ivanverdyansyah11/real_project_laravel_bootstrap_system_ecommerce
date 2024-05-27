<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reward extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    public function reward_transaction() {
        return $this->hasMany(TransactionReward::class, 'id')->withTrashed();
    }
}
