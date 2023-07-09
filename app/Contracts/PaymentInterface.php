<?php

namespace App\Contracts;

use App\Models\Order;

interface PaymentInterface
{
    public function charges(Order $order): string;
}
