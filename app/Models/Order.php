<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
	use HasFactory;

	protected $casts = [
		'user_json' => 'object',
	];

	protected $guard = [];

	/**
	 * Get all of the products for the Order
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function products(): HasMany
	{
		return $this->hasMany(OrderProduct::class);
	}
}
