<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description_min',
        'description_max',
        'availables',
        'price',
        'img',

    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function specifications()
    {
        return $this->belongsToMany(Specification::class)->withPivot('value');
    }

    public function card_products()
    {
        return $this->belongsToMany(User::class)->withPivot('quantity','total_price_quantity');
    }
}
