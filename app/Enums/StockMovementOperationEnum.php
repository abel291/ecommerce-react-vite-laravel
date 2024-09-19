<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StockMovementOperationEnum: string implements HasLabel, HasColor, HasIcon
{
    case ADDITION = 'addition';
    case SUBTRACTION  = 'subtraction';



    public function getLabel(): ?string
    {
        return match ($this) {
            self::ADDITION => 'Adicion (Entrada de mercancia)',
            self::SUBTRACTION => 'Sustracción  (Ajuste de stock)',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::ADDITION => 'success',
            self::SUBTRACTION => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::ADDITION => 'heroicon-m-arrow-up',
            self::SUBTRACTION => 'heroicon-m-arrow-down',
        };
    }
}
