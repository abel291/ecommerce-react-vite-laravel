<?php

namespace App\Services;

use App\Enums\CartEnum;
use App\Models\Cart;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ShoppingCart;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;

class InvoiceService
{
	public static function generateInvoice(Order $order)
	{
		$settings = Settings::data()->all();
		$invoice = Pdf::loadView('pdf.invoice', [
			'order' => $order,
			'company' => $settings['company'],
		])
			->setPaper('a4')
			->setOption(['defaultFont' => 'sans-serif']);;

		//return view('pdf.invoice', compact('order'));
		return $invoice;
	}
}
