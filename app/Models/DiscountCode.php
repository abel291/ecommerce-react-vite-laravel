<?php

namespace App\Models;

use App\Enums\DiscountCodeTypeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiscountCode extends Model
{
	use HasFactory;
	protected $casts = [
		'type' => DiscountCodeTypeEnum::class,
		'start_date' => 'datetime:Y-m-d',
		'end_date' => 'datetime:Y-m-d',
	];

	protected function startDateFormat(): Attribute
	{
		return Attribute::make(
			get: fn () => $this->start_date->isoFormat('DD MMM YYYY'),
		);
	}
	protected function endDateFormat(): Attribute
	{
		return Attribute::make(
			get: fn () => $this->end_date->isoFormat('DD MMM YYYY'),
		);
	}
	public function orders(): HasMany
	{
		return $this->hasMany(Order::class);
	}
	public function calculateDiscount($amount)
	{

		switch ($this->type) {
			case DiscountCodeTypeEnum::FIXED:
				return max(($amount - $this->value), 0);
				break;

			case DiscountCodeTypeEnum::PERCENT:
				return $amount * ($this->value / 100);
				break;
		}
	}
}
