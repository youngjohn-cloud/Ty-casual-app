<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'image',
        'hover_image',
        'description',
        'price',
        'stock',
        'product_category',
        'category_id',
    ];

    /**
     * Get the category for the Product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, "category_id");
    }
}
