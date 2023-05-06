<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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

	public function category(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}

	public function images(): MorphMany
	{
		return $this->morphMany(Image::class, 'imageable');
	}

	public function brand(): BelongsTo
	{
		return $this->belongsTo(Brand::class);
	}

	public function specifications(): HasMany
	{
		return $this->hasMany(Specification::class);
	}

	public function shopping_cart(): BelongsToMany
	{
		return $this->belongsToMany(User::class)->withPivot('quantity', 'total_price_quantity');
	}
	public function orders(): HasMany
	{
		return $this->hasMany(OrderProduct::class);
	}

	public function stock(): hasOne
	{
		return $this->hasOne(Stock::class);
	}
}
