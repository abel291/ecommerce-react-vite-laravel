<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum OrderStatusEnum: string implements HasLabel, HasColor, HasIcon
{
    case CANCELLED = 'canceled';
    case REFUNDED = 'refunded';
    case SUCCESSFUL = 'successful';
    // case PENDING = 'pending';

    public function getLabel(): string
    {
        return match ($this) {
            self::CANCELLED => 'Cancelado',
            self::REFUNDED => 'Reembolsado',
            self::SUCCESSFUL => 'Aceptado',
            // self::PENDING => 'Pendiente',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::CANCELLED => 'gray',
            self::REFUNDED => 'danger',
            self::SUCCESSFUL => 'success',
            // self::PENDING => 'gray',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::REFUNDED => 'heroicon-m-receipt-refund',
            self::SUCCESSFUL => 'heroicon-m-check-circle',
            self::CANCELLED => 'heroicon-m-x-circle',
            // self::PENDING => 'heroicon-m-x-circle',
        };
    }
}
