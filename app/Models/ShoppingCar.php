<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ShoppingCar extends Pivot
{
	protected $table = 'shopping_car';

	protected $fillable = ['user_id', 'product_id', 'quantity', 'total_price'];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
