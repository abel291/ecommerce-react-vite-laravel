<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum CategoryTypeEnum: string implements HasLabel, HasColor, HasIcon
{
    case PRODUCT = 'product';
    case BLOG = 'blog';


    public function getLabel(): string
    {
        return match ($this) {
            self::PRODUCT => 'Producto',
            self::BLOG => 'Blog',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::PRODUCT => 'success',
            self::BLOG => 'info',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::PRODUCT => 'heroicon-m-squares-2x2',
            self::BLOG => 'heroicon-m-chat-bubble-left-right',
        };
    }
}
