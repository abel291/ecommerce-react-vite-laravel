<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ShoppingCart extends Pivot
{
	protected $table = 'shopping_cart';

	protected $fillable = ['id', 'user_id', 'product_id', 'quantity', 'price_quantity'];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
