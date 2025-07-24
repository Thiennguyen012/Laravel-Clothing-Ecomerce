<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    // Chỉ định tên bảng đúng
    protected $table = 'cart';

    // Chỉ định primary key
    protected $primaryKey = 'id';

    // Các field có thể mass assign
    protected $fillable = [
        'user_id',
        'session_id',
        'variant_id',
        'quantity',
        'price'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}
