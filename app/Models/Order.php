<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'name',
        'total_price'
    ];

    protected $casts = [
        'total_price' => 'integer',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Optional: format harga
    public function getFormattedTotalAttribute()
    {
        return 'Rp' . number_format($this->total_price, 0, ',', '.');
    }
}