<?php

namespace App\Models;

use App\Models\Size;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Variant extends model
{
    use HasFactory;

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'model');
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function skus(): HasMany
    {
        return $this->hasMany(Sku::class);
    }

}
