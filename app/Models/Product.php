<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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
		'price_offer',
		'cost',
		'img',
	];

	protected $casts = [
		'price' => 'float',
		'price_offer' => 'float',
	];

	// protected function price(): Attribute
	// {
	// 	return Attribute::make(
	// 		set: fn (string $value) => str_replace(',', '', $value),
	// 	);
	// }
	// protected function cost(): Attribute
	// {
	// 	return Attribute::make(
	// 		set: fn (string $value) => str_replace(',', '', $value),
	// 	);
	// }

	public function department(): BelongsTo
	{
		return $this->belongsTo(Department::class);
	}

	public function category(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}

	public function images(): MorphMany
	{
		return $this->morphMany(Image::class, 'model');
	}

	public function attributes(): BelongsToMany
	{
		return $this->belongsToMany(Attribute::class, 'attribute_product')->distinct();
	}
	public function attribute_values(): BelongsToMany
	{
		return $this->belongsToMany(AttributeValue::class, 'attribute_product');
	}

	public function loadAttributesWithValues()
	{

		$this['attributes']->map(function ($attribute) {
			$attribute->setRelation('attribute_values', $this->attribute_values->where('attribute_id', $attribute->id)->values());
			return $attribute;
		});

		return $this;
	}



	public function brand(): BelongsTo
	{
		return $this->belongsTo(Brand::class);
	}

	public function specifications(): HasMany
	{
		return $this->hasMany(Specification::class);
	}
	public function specificationsGroup(): HasMany
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
			$this->price_offer = round($this->price * ((100 - $this->offer) / 100), 2);
		} else {
			$this->price_offer = $this->price;
		}
	}

	public function scopeInStock(Builder $query): void
	{
		$query->whereRelation('stock', 'remaining', '>', 0);
	}

	public function scopeSelectForCard(Builder $query): void
	{
		$query->select('id', 'slug', 'thumb', 'name', 'offer', 'price', 'price_offer', 'department_id', 'category_id');
	}

	public function scopeBestSeller(Builder $query): void
	{
		$query->withCount(['orders' => function ($query) {
			$query->whereHas('payment', function (Builder $query) {
				$query->where('status', PaymentStatus::SUCCESSFUL);
			});
		}])
			->whereHas('orders.payment', function ($query) {
				$query->where('status', PaymentStatus::SUCCESSFUL);
			})
			->orderBy('orders_count', 'desc');
	}

	public function scopeInOffer(Builder $query): void
	{
		$query->where('offer', '!=', 0);
	}

	/**
	 * Scope a query to only include active users.
	 */
	public function scopeActive(Builder $query): void
	{
		$query->where('active', 1);
	}

	public function scopeActiveInStock($query): void
	{
		$this->active()->inStock();
	}

	public function scopeWithFilters($query, $filters)
	{
		//$search, $categories, $sub_categories, $price_min, $price_max, $brands, $offer, $sortBy
		//dd($categories);
		return $query
			->activeInStock()
			->where(function ($query) use ($filters) {
				$query->orWhere('name', 'like', '%' . $filters['q'] . '%');
				$query->orWhere('slug', 'like', '%' . $filters['q'] . '%');
				$query->orWhere('description_min', 'like', '%' . $filters['q'] . '%');
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
			->when($filters['attribute_values'], function (Builder $query) use ($filters) {

				$query->whereHas('attribute_values', function (Builder $sub_query) use ($filters) {
					$sub_query->whereIn('slug', $filters['attribute_values']);
				});
			})

			->when($filters['sortBy'], function (Builder $query) use ($filters) {
				$sorBy = $filters['sortBy'] == 'price_desc' ? 'desc' : 'asc';
				$query->orderBy('products.price_offer', $sorBy);
			}, function ($query) {
				$query->orderBy('products.id', 'desc');
			});
	}
}
