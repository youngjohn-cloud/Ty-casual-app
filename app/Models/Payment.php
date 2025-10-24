<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'order_id',
        'payment_method',
        'amount',
        'payment_status',
    ];

    /**
     * Get the order that owns the Payment.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
