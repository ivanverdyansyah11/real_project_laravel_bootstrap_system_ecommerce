<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reseller extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class, 'users_id')->withTrashed();
    }

    public function reward_transaction() {
        return $this->hasMany(TransactionReward::class, 'id')->withTrashed();
    }

    public function transaction() {
        return $this->hasMany(Transaction::class, 'id')->withTrashed();
    }
}
