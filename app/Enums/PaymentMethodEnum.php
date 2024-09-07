<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PaymentMethodEnum: string  implements HasLabel, HasColor, HasIcon
{
    case EFECTY = 'efecty';
    case NEQUI = 'nequi';
    case MP = 'mp';
    case CE = 'contra-entrega';
    case CARD = 'card';

    public function getColor(): string
    {
        return match ($this) {
            PaymentMethodEnum::EFECTY => 'gray',
            PaymentMethodEnum::NEQUI => 'gray',
            PaymentMethodEnum::MP => 'gray',
            PaymentMethodEnum::CE => 'gray',
            PaymentMethodEnum::CARD => 'gray',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            PaymentMethodEnum::EFECTY => 'Efecty',
            PaymentMethodEnum::NEQUI => 'Nequi',
            PaymentMethodEnum::MP => 'Mercado pago',
            PaymentMethodEnum::CE => 'Contra Entrega',
            PaymentMethodEnum::CARD => 'Tarjeta',
        };
    }
    public function getIcon(): string
    {
        return match ($this) {
            PaymentMethodEnum::EFECTY => '',
            PaymentMethodEnum::NEQUI => '',
            PaymentMethodEnum::MP => '',
            PaymentMethodEnum::CE => '',
            PaymentMethodEnum::CARD => '',
        };
    }
}
