<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'image',
        'price',
        'stock',
        'is_active',
    ];

    protected $casts = [
        'price' => 'float',
        'stock' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the category that owns the product
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the absolute URL for the product image
     */
    protected function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    /**
     * Append the image_url attribute to JSON response
     */
    protected $appends = ['image_url'];
}