<?php

namespace App\Enums;

enum DiscountCodeTypeEnum: string
{
    case PERCENT = 'percent';
    case FIXED = 'fixed';

    public function color(): string
    {
        return match ($this) {
            DiscountCodeTypeEnum::PERCENT => 'yellow',
            DiscountCodeTypeEnum::FIXED => 'cyan',
        };
    }

    public function text(): string
    {
        return match ($this) {
            DiscountCodeTypeEnum::PERCENT => '%',
            DiscountCodeTypeEnum::FIXED => '$',
        };
    }
}
