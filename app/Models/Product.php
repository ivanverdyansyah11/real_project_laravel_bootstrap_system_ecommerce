<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id')->withTrashed();
    }

    public function productImage()
    {
        return $this->belongsTo(ProductImage::class, 'id')->withTrashed();
    }

    public function package()
    {
        return $this->hasMany(Package::class, 'id')->withTrashed();
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'id')->withTrashed();
    }
}
