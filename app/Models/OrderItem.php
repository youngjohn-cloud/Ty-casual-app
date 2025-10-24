<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    /**
     * Get the order that owns the OrderItem.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    /**
     * Get the product that owns the OrderItem.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
