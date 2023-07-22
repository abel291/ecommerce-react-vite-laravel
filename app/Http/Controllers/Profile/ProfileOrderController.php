<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Services\InvoiceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Inertia\Inertia;
use Inertia\Response;

class ProfileOrderController extends Controller
{
	public function orders(): Response
	{

		$orders = auth()->user()->orders()->with('payment')->orderBy('id', 'desc')->paginate(10);

		return Inertia::render('Profile/Orders', [
			'orders' => OrderResource::collection($orders),
		]);
	}

	public function orderDetails($code)
	{
		$order = auth()->user()->orders()->with('order_products', 'payment')->where('code', $code)->firstOrFail();

		return Inertia::render('Profile/OrderDetails/OrderDetails', [
			'order' => new OrderResource($order),
		]);
	}

	public function invoicePdf($code)
	{
		$order = auth()->user()->orders()->with('order_products', 'payment')->where('code', $code)->firstOrFail();

		$invoice = InvoiceService::generateInvoice($order);

		//return view('pdf.invoice', compact('order'));
		return $invoice->stream();
	}
}
