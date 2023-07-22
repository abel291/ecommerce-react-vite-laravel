<?php

namespace App\Enums;

enum CartEnum: string
{
	case SHOPPING_CART = 'shopping-cart';
	case WISH_LIST = 'wish-list';
	case ORDER = 'order';
	case CHECKOUT = 'checkout';

	public function text(): string
	{
		return match ($this) {
			CartEnum::SHOPPING_CART => 'Carrito de compras',
			CartEnum::WISH_LIST => 'Lista de deseos',
			CartEnum::ORDER => 'order',
		};
	}
}
