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

class Sku extends model
{
    use HasFactory;


    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
