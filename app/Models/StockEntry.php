<?php

namespace App\Models;

use App\Enums\StockStatuEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StockEntry extends Model
{
    use HasFactory;

    public function sku(): BelongsTo
    {
        return $this->belongsTo(Sku::class);
    }
}
