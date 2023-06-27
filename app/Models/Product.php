<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

use function Pest\Laravel\get;

class Product extends Model
{
	use HasFactory;
	//public $quantity_selected = 0;
	//public $price_quantity = 0;
	//public $in_stock;

	protected $fillable = [
		'name',
		'slug',
		'description_min',
		'description_max',
		'availables',
		'price',
		'price_offer',
		'cost',
		'img',
	];

	protected $casts = [
		'price' => 'float',
		'price_offer' => 'float',
	];

	protected function price(): Attribute
	{
		return Attribute::make(
			set: fn (string $value) => str_replace(',', '', $value),
		);
	}
	protected function cost(): Attribute
	{
		return Attribute::make(
			set: fn (string $value) => str_replace(',', '', $value),
		);
	}

	public function department(): BelongsTo
	{
		return $this->belongsTo(Category::class, 'department_id');
	}

	public function category(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}

	public function images(): MorphMany
	{
		return $this->morphMany(Image::class, 'model');
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
	public function orders_product(): HasMany
	{
		return $this->hasMany(OrderProduct::class)->has('order');
	}
	public function orders(): HasManyThrough
	{
		return $this->hasManyThrough(
			Order::class,
			OrderProduct::class,
			'product_id',
			'id',
			'id',
			'order_id'
		);
	}

	public function stock(): hasOne
	{
		return $this->hasOne(Stock::class);
	}

	public function calculateOffer()
	{
		if ($this->offer) {
			return	round($this->price * ((100 - $this->offer) / 100), 2);
		} else {
			return $this->price;
		}
	}
	public function scopeInStock(Builder $query): void
	{
		$query->whereRelation('stock', 'remaining', '>', 0);
	}
	public function scopeActive(Builder $query): void
	{
		$query->where('active', 1);
	}
	public function scopeActiveInStock(Builder $query): void
	{
		$query->active()->inStock();
	}
	public function scopeWithFilters($query, $filters)
	{
		//$search, $categories, $sub_categories, $price_min, $price_max, $brands, $offer, $sortBy
		//dd($categories);
		return $query
			->activeInStock()
			->where(function ($query) use ($filters) {
				$query->orWhere('name', 'like', "%" . $filters['q'] . "%");
				$query->orWhere('slug', 'like', "%" . $filters['q'] . "%");
				$query->orWhere('description_min', 'like', "%" . $filters['q'] . "%");
			})

			->when($filters['department'], function (Builder $query) use ($filters) {
				$query->whereHas('department', function (Builder $sub_query) use ($filters) {
					$sub_query->whereIn('slug', $filters['department']);
				});
			})

			->when($filters['category'], function (Builder $query) use ($filters) {
				$query->whereHas('category', function (Builder $sub_query) use ($filters) {
					$sub_query->whereIn('slug', $filters['category']);
				});
			})

			->when($filters['brands'], function (Builder $query) use ($filters) {
				$query->whereHas('brand', function (Builder $sub_query) use ($filters) {
					$sub_query->whereIn('slug', $filters['brands']);
				});
			})

			->when($filters['price_min'], function (Builder $query) use ($filters) {
				$query->where('price_offer', '>=', $filters['price_min']);
			})

			->when($filters['price_max'], function (Builder $query) use ($filters) {
				$query->where('price_offer', '<=', $filters['price_max']);
			})

			->when($filters['offer'], function (Builder $query) use ($filters) {
				$query->where('offer', '>=', $filters['offer']);
			})

			->when($filters['sortBy'], function (Builder $query) use ($filters) {
				$sorBy = $filters['sortBy'] == 'price_desc' ? 'desc' : 'asc';
				$query->orderBy('price_offer', $sorBy);
			}, function ($query) {
				$query->orderBy('id', 'desc');
			});;
	}
}
