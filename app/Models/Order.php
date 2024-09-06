<?php

namespace App\Models;
use App\Enums\OrderStatusEnum;
use App\Enums\PaymentMethodEnum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $casts = [
        'data' => 'object',
        'discount' => 'object',
        'tax' => 'object',
        'shipping' => 'float',
        'status' => OrderStatusEnum::class,
    ];

    protected $guarded = [];

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class)->withDefault([
            'method' => PaymentMethodEnum::CARD,
        ]);
    }
}
