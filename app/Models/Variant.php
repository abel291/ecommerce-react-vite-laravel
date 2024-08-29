<?php

namespace App\Models;

use App\Models\Size;
use Illuminate\Database\Eloquent\Builder;
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
    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class)->withPivot('stock');
    }
    public function sizesAvailable(): BelongsToMany
    {
        return $this->belongsToMany(Size::class)->wherePivot('stock', '>', 0);
    }

    public function scopeAvailable(Builder $query): void
    {
        $query->with('color')->inStock()->productAvailable();
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

    public function scopeInStock(Builder $query): void
    {
        $query
            ->has('sizesAvailable')
            ->orWhere('default', 1);
    }

    public function scopeActiveInStock($query): void
    {
        $query->active()->inStock();
    }


    public function scopeWithFilters($query, $filters)
    {
        return $query
            ->activeInStock()
            ->with('color')
            // ->when($filters['colors'], function (Builder $query) use ($filters) {
            //     $query->whereIn('color_id', $filters['colors']);
            // })
            ->with(['product' => function ($query) {
                $query->with('variants.color')->orderByDesc('price');
            }])
            // ->when($filters['sizes'], function (Builder $query) use ($filters) {
            //     $query->whereHas('sizesAvailable', function ($query) use ($filters) {
            //         $query->whereIn('sizes.id', $filters['sizes']);
            //     });
            // })
            // ->withWhereHas('product', function ($query) use ($filters) {
            //     $query->selectForCard();
            // })
        ;
    }
}
