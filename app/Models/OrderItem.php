<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    protected $fillable = [
        'order_id',
        'variant_id',
        'product_name',
        'variant_sku',
        'color',
        'size',
        'product_image',
        'quantity',
        'unit_price',
        'total_price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
