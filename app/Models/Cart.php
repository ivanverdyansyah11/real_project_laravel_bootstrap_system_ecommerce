<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id')->withTrashed();
    }
}
