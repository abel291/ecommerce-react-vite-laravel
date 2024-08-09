<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
	use HasFactory;

	public function product()
	{
		return $this->belongsTo(Product::class, 'product_attribute_values');
	}
	public function attribute_value()
	{
		return $this->belongsTo(AttributeValue::class);
	}

	public function product_attribute()
	{
		return $this->belongsTo(ProductAttribute::class)->with('attribute');
	}
}
