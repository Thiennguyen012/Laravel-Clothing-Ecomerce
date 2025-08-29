<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';
    protected $guarded = ['product_id'];

    // Specify fillable fields for mass assignment
    protected $fillable = [
        'category_id',
        'product_name',
        'description',
        'is_active'
    ];

    // Cast certain fields to specific types
    protected $casts = [
        // 'images' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2'
    ];

    // Relationships

    /**
     * Product belongs to a Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    /**
     * Product has many Variants
     */
    public function variants()
    {
        return $this->hasMany(Variant::class, 'product_id', 'product_id');
    }

    public function ratings()
    {
        // hasManyThrough params: related, through, firstKey (on through -> product_id),
        // secondKey (on related -> variant_id), localKey (on parent -> product_id),
        // secondLocalKey (on through -> id)
        return $this->hasManyThrough(Rating::class, Variant::class, 'product_id', 'variant_id', 'product_id', 'id');
    }

    // Additional useful methods

    /**
     * Get active variants only
     */
    public function activeVariants()
    {
        return $this->hasMany(Variant::class, 'product_id', 'product_id')
            ->where('is_active', true);
    }

    /**
     * Get the lowest price among variants
     */
    public function getMinPriceAttribute()
    {
        return $this->variants()->min('price');
    }

    /**
     * Get the highest price among variants
     */
    public function getMaxPriceAttribute()
    {
        return $this->variants()->max('price');
    }

    /**
     * Check if product has stock
     */
    public function hasStock()
    {
        return $this->variants()->where('quantity', '>', 0)->exists();
    }

    /**
     * Get total stock across all variants
     */
    public function getTotalStockAttribute()
    {
        return $this->variants()->sum('quantity');
    }
}
