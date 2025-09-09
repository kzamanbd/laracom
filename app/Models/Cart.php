<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'customer_id',
        'currency',
        'subtotal',
        'discount_total',
        'tax_total',
        'shipping_total',
        'total',
        'status',
        'last_activity_at',
        'expires_at',
        'meta',
        'coupon_code',
        'coupon_discount',
    ];

    protected function casts(): array
    {
        return [
            'meta' => 'array',
            'subtotal' => 'decimal:2',
            'discount_total' => 'decimal:2',
            'tax_total' => 'decimal:2',
            'shipping_total' => 'decimal:2',
            'total' => 'decimal:2',
            'coupon_discount' => 'decimal:2',
            'last_activity_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the cart
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the customer that owns the cart
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the cart items
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Update cart totals based on items
     */
    public function updateTotals(): void
    {
        $items = $this->items()->with('product', 'tax')->get();

        $subtotal = $items->sum('total_price');
        $taxTotal = $items->sum('tax_amount');

        $discountTotal = $this->coupon_discount ?? 0;
        $shippingTotal = $this->shipping_total ?? 0;

        $total = $subtotal + $taxTotal + $shippingTotal - $discountTotal;

        $this->update([
            'subtotal' => $subtotal,
            'tax_total' => $taxTotal,
            'discount_total' => $discountTotal,
            'total' => max(0, $total), // Ensure total is never negative
            'last_activity_at' => now(),
        ]);
    }

    /**
     * Check if cart is empty
     */
    public function isEmpty(): bool
    {
        return $this->items()->count() === 0;
    }

    /**
     * Get cart item count
     */
    public function getItemCountAttribute(): int
    {
        return $this->items()->sum('quantity');
    }

    /**
     * Mark cart as abandoned
     */
    public function markAsAbandoned(): void
    {
        $this->update(['status' => 'abandoned']);
    }

    /**
     * Mark cart as converted (order created)
     */
    public function markAsConverted(): void
    {
        $this->update(['status' => 'converted']);
    }

    /**
     * Scope for active carts
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for abandoned carts
     */
    public function scopeAbandoned($query)
    {
        return $query->where('status', 'abandoned');
    }

    /**
     * Scope for expired carts
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }

    /**
     * Clean up expired carts
     */
    public static function cleanupExpired(): int
    {
        return static::expired()->delete();
    }
}
