<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    public function products() {
        return $this->hasMany(Product::class, 'id')->withTrashed();
    }
}
