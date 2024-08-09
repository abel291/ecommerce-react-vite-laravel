<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderProduct extends Model
{
	use HasFactory;

	protected $casts = [
		'quantity_selected' => 'integer',
		'price' => 'float',
		'price_quantity' => 'float',
		'data' => 'object',
		'attributes' => 'object',
	];

	protected $guarded = [];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function order(): BelongsTo
	{
		return $this->belongsTo(Order::class);
	}

	public function product(): BelongsTo
	{
		return $this->belongsTo(Product::class);
	}

	public function orderAttributes(): HasMany
	{
		return $this->hasMany(OrderAttribute::class);
	}
}
