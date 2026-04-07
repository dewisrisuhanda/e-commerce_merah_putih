<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    /** @use HasFactory<\Database\Factories\OrderDetailFactory> */
    use HasFactory;

    protected $table    = 'order_details';
    protected $fillable = [
        'order_id', 'product_id',
        'product_name', 'product_price', 'quantity', 'subtotal',
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'subtotal'     => 'decimal:2',
    ];


    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')->withTrashed();
    }
}
