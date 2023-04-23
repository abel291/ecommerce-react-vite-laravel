<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
	public function order($code)
	{
		$order = auth()->user()->orders()->with('products')->where('code', $code)->first();
		return Inertia::render('Order/Order', [
			'order' => new OrderResource($order),
		]);
	}
}
