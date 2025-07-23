<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'category_id';
    protected $guarded = ['category_id'];


    // relationship
    public function product()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }
}
