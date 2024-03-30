<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id');
    }

    public function reseller()
    {
        return $this->belongsTo(Reseller::class, 'resellers_id');
    }
}
