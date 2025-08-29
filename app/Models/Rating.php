<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'rating';
    protected $guarded = 'id';
    protected $primaryKey = 'id';

    protected $fillable = [
        'variant_id',
        'user_id',
        'session_id',
        'star',
        'comment',
        'reviewer_name',
    ];

    public function variant(){
        return $this->belongsTo(Variant::class, 'variant_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
