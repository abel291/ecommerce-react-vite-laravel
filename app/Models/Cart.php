<?php

namespace App\Models;

use App\Enums\CartEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';

    protected $fillable = ['id', 'user_id', 'product_id', 'quantity_selected', 'price', 'price_quantity'];

    protected $casts = [
        'quantity_selected' => 'integer',
        'price' => 'float',
        'price_quantity' => 'float',
        'type' => CartEnum::class,
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
        //->select('id', 'name', 'slug', 'price_offer');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
