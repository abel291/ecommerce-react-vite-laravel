<?php

namespace App\Enums;

enum PaymentMethodEnum: string
{
	case EFECTY = 'efecty';
	case NEQUI = 'nequi';
	case MP = 'mp';

	public function color(): string
	{
		return match ($this) {
			PaymentMethodEnum::EFECTY => 'yellow',
			PaymentMethodEnum::NEQUI => 'indigo',
			PaymentMethodEnum::MP => 'blue',
		};
	}
	public function text(): string
	{
		return match ($this) {
			PaymentMethodEnum::EFECTY => 'Efecty',
			PaymentMethodEnum::NEQUI => 'Nequi',
			PaymentMethodEnum::MP => 'Mercado pago',
		};
	}
}
