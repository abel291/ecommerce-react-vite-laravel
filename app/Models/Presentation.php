<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Presentation extends Model
{
    use HasFactory;
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute_values(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValue::class);
    }
}
