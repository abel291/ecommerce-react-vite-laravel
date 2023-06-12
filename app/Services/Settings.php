<?php

namespace App\Services;

use App\Enums\CartEnum;
use App\Models\Cart;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use Spatie\Valuestore\Valuestore;

class Settings
{

	public static  function data()
	{
		return Valuestore::make(config_path('settings.json'));
	}
}
