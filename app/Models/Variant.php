<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    // relationship

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
