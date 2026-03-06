<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'product_id',
        'user_id',
        'starts_at',
        'expires_at',
        'max_uses',
        'uses_count',
        'is_active',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'value' => 'decimal:2',
        'max_uses' => 'integer',
        'uses_count' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function isValid($user = null): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->starts_at && $this->starts_at->isFuture()) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($this->max_uses !== null && $this->uses_count >= $this->max_uses) {
            return false;
        }

        if ($this->user_id !== null) {
            if (!$user || $user->id !== $this->user_id) {
                return false;
            }
        }

        if ($user && $this->users()->where('user_id', $user->id)->exists()) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($total, $cart = []): float
    {
        if ($this->type === 'percentage') {
            return round($total * ($this->value / 100), 2);
        }

        if ($this->type === 'fixed_amount') {
            return (float) $this->value;
        }

        if ($this->type === 'fixed_product') {
            $productInCart = collect($cart)->first(fn($item) => $item['id'] == $this->product_id);
            if ($productInCart) {
                return (float) $productInCart['price'];
            }
        }

        return 0;
    }
}
