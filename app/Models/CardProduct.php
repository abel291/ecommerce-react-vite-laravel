<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CardProduct extends Pivot
{
    protected $table = 'product_user';

    protected $fillable = ['user_id', 'product_id', 'quantity', 'total_price'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
