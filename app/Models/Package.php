<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    public function product() {
        return $this->belongsTo(Product::class, 'products_id')->withTrashed();
    }
}
