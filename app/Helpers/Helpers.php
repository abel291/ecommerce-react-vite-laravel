<?php

namespace App\Helpers;

class Helpers
{
    public static function get_charges_products($amount)
    {

        $tax_percent = 0.12;
        $shipping = 11;
        $sub_total = $amount;
        $tax_amount = round($sub_total * $tax_percent, 2);
        $total = round($sub_total + $tax_amount + $shipping, 2);

        return [
            'sub_total' => $sub_total,
            'tax_percent' => $tax_percent,
            'tax_amount' => $tax_amount,
            'shipping' => $shipping,
            'total' => $total,
        ];
    }
}
