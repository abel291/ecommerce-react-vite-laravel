<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum OrderStatusEnum: string implements HasLabel, HasColor, HasIcon
{
    case CANCELED = 'canceled';
    case REFUNDED = 'refunded';
    case SUCCESSFUL = 'successful';
    case PENDING = 'pending';

    public function getLabel(): string
    {
        return match ($this) {
            OrderStatusEnum::CANCELED => 'Cancelado',
            OrderStatusEnum::REFUNDED => 'Reembolsado',
            OrderStatusEnum::SUCCESSFUL => 'Aceptado',
            OrderStatusEnum::PENDING => 'Pendiente',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            OrderStatusEnum::CANCELED => 'danger',
            OrderStatusEnum::REFUNDED => 'danger',
            OrderStatusEnum::SUCCESSFUL => 'success',
            OrderStatusEnum::PENDING => 'gray',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            OrderStatusEnum::CANCELED => 'heroicon-s-x',
            OrderStatusEnum::REFUNDED => 'heroicon-o-receipt-refund',
            OrderStatusEnum::SUCCESSFUL => 'heroicon-s-check',
            OrderStatusEnum::PENDING => 'heroicon-s-check',
        };
    }
}
