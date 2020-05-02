<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'product_id',
        'discount_id',
        'qty',
        'price',
        'discount_value'
    ];
    protected $appends = ['total_price', 'price_after_discount'];

    /**
     * Relation products table
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    /**
     * Relation discount table
     */
    public function discount()
    {
        return $this->belongsTo('App\Models\Discount', 'discount_id');
    }

    /**
     * Accessor total price
     */
    public function getTotalPriceAttribute()
    {
        return $this->qty * $this->price;
    }

    /**
     * Accessor total price after discount
     */
    public function getPriceAfterDiscountAttribute()
    {
        return $this->qty * $this->price - $this->discount_value;
    }
}
