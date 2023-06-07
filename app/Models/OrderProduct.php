<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProduct extends Model
{
	use HasFactory;

	protected $casts = [
		'quantity_selected' => 'integer',
		'price' => 'float',
		'price_quantity' => 'float',
		'data' => 'object',
	];


	protected $guarded  = [];

	public function user()
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
}
