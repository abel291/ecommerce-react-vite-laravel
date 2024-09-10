<?php

namespace App\Models;

use App\Models\Attribute\ColorAttribute;
use App\Models\Attribute\SizeAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Presentation extends Model
{
    use HasFactory;
    protected $casts = [
        'code' => 'integer',
    ];
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(ColorAttribute::class, 'color_attribute_id');
    }
    public function size(): BelongsTo
    {
        return $this->belongsTo(SizeAttribute::class, 'size_attribute_id');
    }
}
