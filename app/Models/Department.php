<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function metaTag()
    {
        return $this->morphOne(MetaTag::class, 'model');
    }

    public function categories_active(): HasMany
    {
        return $this->hasMany(Category::class)->where('active', true);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }
}
