<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderAttribute extends Model
{
	use HasFactory;

	protected $fillable = ['attribute_id', 'attribute_value_id'];

	public function attribute(): BelongsTo
	{
		return $this->belongsTo(Attribute::class);
	}
	public function attribute_value(): BelongsTo
	{
		return $this->belongsTo(AttributeValue::class);
	}
}
