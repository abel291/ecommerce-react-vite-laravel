<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Specification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'slug',
        'value',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function specificationValues(): HasMany
    {
        return $this->hasMany(SpecificationValue::class);
    }
}
