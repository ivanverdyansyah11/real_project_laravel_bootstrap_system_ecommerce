<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionReward extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    public function reward() {
        return $this->belongsTo(Reward::class, 'rewards_id')->withTrashed();
    }

    public function reseller() {
        return $this->belongsTo(Reseller::class, 'resellers_id')->withTrashed();
    }
}
