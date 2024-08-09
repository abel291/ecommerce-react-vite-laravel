<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductAttribute extends Model
{
	use HasFactory;

	public function product(): BelongsTo
	{
		return $this->belongsTo(Product::class,);
	}
	public function attribute(): BelongsTo
	{
		return $this->belongsTo(Attribute::class);
	}
	public function product_attribute_values(): HasMany
	{
		return $this->hasMany(ProductAttributeValue::class)->with('attribute_value');
	}
}
