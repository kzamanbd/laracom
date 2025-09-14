<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentTransaction extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    protected $fillable = [
        'order_id',
        'provider',
        'reference',
        'amount',
        'currency',
        'status',
        'payload',
        'processed_at',
    ];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
            'amount' => 'decimal:2',
            'processed_at' => 'datetime',
        ];
    }

    /**
     * Get the order this transaction belongs to
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
