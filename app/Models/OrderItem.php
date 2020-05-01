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
        'discount'
    ];

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
}
