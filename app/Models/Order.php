<?php

namespace App\Models;

use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

class Order extends Model
{
	use HasFactory;

	protected $casts = [
		'user_data' => 'object',
		'discount' => 'object',
	];

	protected $guarded  = [];


	public function order_products(): HasMany
	{
		return $this->hasMany(OrderProduct::class);
	}
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
	public function payment(): HasOne
	{
		return $this->hasOne(Payment::class)->withDefault([
			'status' => PaymentStatus::PENDING,
			'method' => PaymentMethodEnum::CARD
		]);
	}
}
