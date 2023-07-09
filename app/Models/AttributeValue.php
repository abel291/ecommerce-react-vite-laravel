<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AttributeValue extends Model
{
	use HasFactory;
	public function products(): BelongsToMany
	{
		return $this->belongsToMany(Product::class, 'attribute_product');
	}
	public function attribute(): BelongsTo
	{
		return $this->belongsTo(Attribute::class);
	}
}
