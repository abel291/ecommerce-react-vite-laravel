<?php

namespace App\Enums;

enum PaymentMethodEnum: string
{
    case EFECTY = 'efecty';
    case NEQUI = 'nequi';
    case MP = 'mp';
    case CE = 'contra-entrega';
    case CARD = 'card';

    public function color(): string
    {
        return match ($this) {
            PaymentMethodEnum::EFECTY => 'yellow',
            PaymentMethodEnum::NEQUI => 'indigo',
            PaymentMethodEnum::MP => 'blue',
            PaymentMethodEnum::CE => 'gray',
            PaymentMethodEnum::CARD => 'green',
        };
    }

    public function text(): string
    {
        return match ($this) {
            PaymentMethodEnum::EFECTY => 'Efecty',
            PaymentMethodEnum::NEQUI => 'Nequi',
            PaymentMethodEnum::MP => 'Mercado pago',
            PaymentMethodEnum::CE => 'Contra Entrega',
            PaymentMethodEnum::CARD => 'Targeta',
        };
    }
}
