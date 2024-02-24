<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function transaction() {
        return $this->hasMany(Transaction::class, 'id');
    }
}
