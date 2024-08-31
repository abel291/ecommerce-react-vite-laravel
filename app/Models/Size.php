<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Size extends Model
{
    use HasFactory;

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'skus')->withPivot('stock');
    }

    public function variants(): belongsToMany
    {
        return $this->belongsToMany(Variant::class, 'skus')->withPivot('stock');
    }
}