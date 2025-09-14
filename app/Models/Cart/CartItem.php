<?php

namespace App\Models\Cart;

use App\Models\Catalog\Product;
use App\Models\System\Tax;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price',
        'currency',
        'product_name',
        'product_sku',
        'product_attributes',
        'tax_id',
        'tax_rate',
        'tax_amount',
        'meta',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'product_attributes' => 'array',
            'meta' => 'array',
            'unit_price' => 'decimal:2',
            'total_price' => 'decimal:2',
            'tax_rate' => 'decimal:4',
            'tax_amount' => 'decimal:2',
            'quantity' => 'integer',
        ];
    }

    /**
     * Get the cart that owns the item
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the tax
     */
    public function tax(): BelongsTo
    {
        return $this->belongsTo(Tax::class);
    }

    /**
     * Update quantity and recalculate totals
     */
    public function updateQuantity(int $quantity): void
    {
        if ($quantity <= 0) {
            $this->delete();

            return;
        }

        $this->quantity = $quantity;
        $this->calculateTotals();
        $this->save();

        // Update cart totals
        $this->cart->updateTotals();
    }

    /**
     * Calculate item totals based on quantity and tax
     */
    public function calculateTotals(): void
    {
        $this->total_price = $this->unit_price * $this->quantity;

        if ($this->tax_rate > 0) {
            $this->tax_amount = ($this->total_price * $this->tax_rate) / 100;
        } else {
            $this->tax_amount = 0;
        }
    }

    /**
     * Boot the model
     */
    protected static function boot(): void
    {
        parent::boot();

        // Automatically calculate totals when creating/updating
        static::saving(function ($cartItem) {
            $cartItem->calculateTotals();
        });

        // Update cart totals when cart item is saved or deleted
        static::saved(function ($cartItem) {
            $cartItem->cart->updateTotals();
        });

        static::deleted(function ($cartItem) {
            $cartItem->cart->updateTotals();
        });
    }

    /**
     * Check if this item has the same product and attributes as another
     */
    public function isSameAs(int $productId, ?array $attributes = null): bool
    {
        return $this->product_id === $productId &&
            $this->product_attributes === $attributes;
    }

    /**
     * Get the display name with attributes
     */
    public function getDisplayNameAttribute(): string
    {
        $name = $this->product_name;

        if (! empty($this->product_attributes)) {
            $attributes = collect($this->product_attributes)
                ->map(fn ($value, $key) => ucfirst($key).': '.$value)
                ->implode(', ');

            $name .= ' ('.$attributes.')';
        }

        return $name;
    }
}
