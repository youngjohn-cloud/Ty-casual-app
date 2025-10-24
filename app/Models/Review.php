<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'product_id',
        'user_id',
        'comment',
        'rating',
    ];

    /**
     * Get the product that this review belongs to.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    /**
     * Get the user that wrote this review.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
