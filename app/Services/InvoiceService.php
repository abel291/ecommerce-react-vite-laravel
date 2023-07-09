<?php

namespace App\Services;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceService
{
    public static function generateInvoice(Order $order)
    {
        $settings = SettingService::data();
        $invoice = Pdf::setOption(['defaultFont' => 'sans-serif'])
            ->loadView('pdf.invoice', [
                'order' => $order,
                'company' => $settings['company'],
            ])->setPaper('a4');

        //return view('pdf.invoice', compact('order'));
        return $invoice;
    }
}
