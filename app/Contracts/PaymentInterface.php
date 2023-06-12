<?php

namespace App\Contracts;

use App\Models\DiscountCode;
use App\Models\Order;
use Illuminate\Support\Collection;

interface PaymentInterface
{
	public function charges(Order $order): string;
}
