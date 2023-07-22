<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{

	use HasFactory;

	public function product(): BelongsTo
	{
		return $this->belongsTo(Product::class);
	}

	public function attribute_values(): HasMany
	{
		return $this->hasMany(AttributeValue::class);
	}
}
