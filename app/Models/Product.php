<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    public function category() {
        return $this->belongsTo(Category::class, 'categories_id');
    }

    public function transaction() {
        return $this->hasMany(Transaction::class, 'id');
    }
}
