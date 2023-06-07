<?php

namespace App\Enums;

enum CartEnum: string
{
	case SHOPPIN_CART = 'shopping-cart';
	case WISH_LIST = 'wish-list';
	case ORDER = 'order';

	public function text(): string
	{
		return match ($this) {
			CartEnum::SHOPPIN_CART => 'Carrito de compras',
			CartEnum::WISH_LIST => 'Lista de deseos',
			CartEnum::ORDER => 'order',
		};
	}
}
