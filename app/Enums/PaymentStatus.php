<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case CANCELED = 'canceled';
    case REFUNDED = 'refunded';
    case SUCCESSFUL = 'successful';
    case PENDING = 'pending';

    public function text(): string
    {
        return match ($this) {
            PaymentStatus::CANCELED => 'Cancelado',
            PaymentStatus::REFUNDED => 'Reembolsado',
            PaymentStatus::SUCCESSFUL => 'Aceptado',
            PaymentStatus::PENDING => 'Pendiente',
        };
    }

    public function color(): string
    {
        return match ($this) {
            PaymentStatus::CANCELED => 'red',
            PaymentStatus::REFUNDED => 'red',
            PaymentStatus::SUCCESSFUL => 'green',
            PaymentStatus::PENDING => 'gray',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            PaymentStatus::CANCELED => 'heroicon-s-x',
            PaymentStatus::REFUNDED => 'heroicon-o-receipt-refund',
            PaymentStatus::SUCCESSFUL => 'heroicon-s-check',
            PaymentStatus::PENDING => 'heroicon-s-check',
        };
    }
}
