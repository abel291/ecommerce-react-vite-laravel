<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AttributeProduct extends Model
{

	protected $table = "attribute_product";
	/**
	 * Indicates if the IDs are auto-incrementing.
	 *
	 * @var bool
	 */
	public $incrementing = true;

	public function product(): BelongsTo
	{
		return $this->belongsTo(Product::class);
	}
	public function attribute(): BelongsTo
	{
		return $this->belongsTo(Attribute::class);
	}
	public function attribute_values(): BelongsToMany
	{
		return $this->BelongsToMany(AttributeValue::class, 'product_attribute_values');
	}
}
