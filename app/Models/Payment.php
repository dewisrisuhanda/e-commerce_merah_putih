<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;


    protected $table    = 'payments';
    protected $fillable = [
        'order_id',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'snap_token',
        'payment_type',
        'gross_amount',
        'status',
        'midtrans_response',
        'paid_at',
    ];

    protected $casts = [
        'midtrans_response' => 'array',
        'gross_amount'      => 'decimal:2',
        'paid_at'           => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function isPaid(): bool
    {
        return $this->status === 'settlement';
    }
}
