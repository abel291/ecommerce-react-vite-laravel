<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Sku extends Model
{
    use HasFactory;


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }
    public function order_products(): HasOne
    {
        return $this->hasOne(OrderProduct::class);
    }
}
