<?php

namespace App\Models;

use App\Enums\DiscountCodeTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiscountCode extends Model
{
    use HasFactory;

    protected $casts = [
        'value' => 'float',
        'type' => DiscountCodeTypeEnum::class,
        'valid_from' => 'datetime:Y-m-d',
        'valid_to' => 'datetime:Y-m-d',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function calculateDiscount(float $amount): float
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
