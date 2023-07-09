<?php

namespace App\Services;

use App\Models\Product;

class StockService
{
    public static function producInStock($id, $quantity)
    {
        return Product::where('active', 1)
            ->whereRelation('stock', 'remaining', '>=', $quantity)
            ->find($id);
    }
}
