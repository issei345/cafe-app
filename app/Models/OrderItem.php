<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'menu_id',
        'quantity',
        'price'
    ];

    // Casting biar data konsisten (penting untuk API)
    protected $casts = [
        'quantity' => 'integer',
        'price' => 'integer',
    ];

    /**
     * Relasi ke Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi ke Menu (produk)
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Accessor subtotal (quantity * price)
     */
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->price;
    }
}