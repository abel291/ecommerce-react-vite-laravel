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

	public function calculateDiscount(float $amount)
	{

		$applied = 0;
		switch ($this->type) {
			case DiscountCodeTypeEnum::FIXED:
				$applied = max(($amount - $this->value), 0);
				break;

			case DiscountCodeTypeEnum::PERCENT:
				$applied = $amount * ($this->value / 100);
				break;
		}
		return round($applied, 2);
	}
}
