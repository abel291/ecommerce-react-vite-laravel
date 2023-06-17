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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Spatie\Valuestore\Valuestore;

class SettingService
{


	public static function getSettingsValuestore()
	{
		return Valuestore::make(config_path('settings.json'));
	}

	public static function data()
	{
		return self::getSettingsValuestore()->all();
	}

	public static function put($data)
	{
		Cache::forget('settings');
		self::getSettingsValuestore()->put($data);
	}
}
