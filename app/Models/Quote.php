<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Quote extends Model
{
    protected $guarded = [];

    protected static function booted(): void
    {
        static::addGlobalScope('assignedToUser', function (Builder $builder) {
            if (auth()->check() && auth()->user()->role !== 'admin') {
                $builder->where('user_id', auth()->id());
            }
        });
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(QuoteItem::class);
    }

    protected function totalAmount(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => 
                self::calculateTotal($attributes['subtotal'] ?? 0, $attributes['stc_discount'] ?? 0)
        );
    }

    protected function gstAmount(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => 
                self::calculateGst($attributes['subtotal'] ?? 0, $attributes['stc_discount'] ?? 0)
        );
    }

    public static function calculateGst($subtotal, $stcDiscount)
    {
        return max(0, ($subtotal - $stcDiscount) * 0.10);
    }

    public static function calculateTotal($subtotal, $stcDiscount)
    {
        $gst = self::calculateGst($subtotal, $stcDiscount);
        return max(0, ($subtotal - $stcDiscount) + $gst);
    }
}
