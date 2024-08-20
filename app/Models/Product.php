<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Models\Attribute;
use App\Models\Attribute\ColorAttribute;
use Gloudemans\Shoppingcart\Contracts\Buyable;
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
        'price',
        'cost',
        'img',
    ];

    protected $casts = [
        'price' => 'float',
        'price' => 'float',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function presentations(): HasMany
    {
        return $this->hasMany(Presentation::class);
    }

    public function presentation(): HasOne
    {
        return $this->hasOne(Presentation::class)->where('default', 1);
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

    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(ColorAttribute::class, 'presentations')->distinct();
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
    public function calculateOffer()
    {
        if ($this->offer) {
            $this->old_price = $this->price;
            $this->price = round($this->old_price * ((100 - $this->offer) / 100), 2);
        } else {
            $this->price = $this->price;
        }
    }

    public function scopeInStock(Builder $query): void
    {
        $query->whereRelation('presentations', 'stock', '>', 0);
    }

    public function scopeSelectForCard(Builder $query): void
    {
        $query->select(
            'id',
            'slug',
            'thumb',
            'name',
            'offer',
            'price',
            'old_price',
            'department_id',
            'category_id'
        )
            ->with('colors');
    }

    public function scopeBestSeller(Builder $query): void
    {
        $query->withCount([
            'orders' => function ($query) {
                $query->whereHas('payment', function (Builder $query) {
                    $query->where('status', PaymentStatus::SUCCESSFUL);
                });
            }
        ])
            ->whereHas('orders.payment', function ($query) {
                $query->where('status', PaymentStatus::SUCCESSFUL);
            })
            ->orderBy('orders_count', 'desc');
    }

    public function scopeInOffer(Builder $query): void
    {
        $query->where('offer', '!=', 0);
    }


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

        return $query
            ->activeInStock()

            // ->where(function ($query) use ($filters) {
            //     $query->orWhere('name', 'like', '%' . $filters['q'] . '%');
            //     $query->orWhere('slug', 'like', '%' . $filters['q'] . '%');
            //     $query->orWhere('description_min', 'like', '%' . $filters['q'] . '%');
            // })
            ->when($filters['q'], function (Builder $query) use ($filters) {
                $query->where(function ($query) use ($filters) {
                    $query->orWhere('name', 'like', '%' . $filters['q'] . '%');
                    $query->orWhere('slug', 'like', '%' . $filters['q'] . '%');
                    $query->orWhere('description_min', 'like', '%' . $filters['q'] . '%');
                });
            })
            ->when($filters['departments'], function (Builder $query) use ($filters) {
                $query->whereIn('department_id', $filters['departments']);
                // $query->whereHas('department', function (Builder $sub_query) use ($filters) {
                //     $sub_query->whereIn('id', $filters['departments']);
                // });
            })

            ->when($filters['categories'], function (Builder $query) use ($filters) {
                $query->whereIn('category_id', $filters['categories']);
                // $query->whereHas('category', function (Builder $sub_query) use ($filters) {
                //     $sub_query->whereIn('id', $filters['categories']);
                // });
            })

            ->when(($filters['colors'] || $filters['sizes']), function (Builder $query) use ($filters) {

                $query->whereHas('presentation', function (Builder $sub_query) use ($filters) {
                    $sub_query->when($filters['colors'], function (Builder $query) use ($filters) {
                        $query->whereIn('color_attribute_id', $filters['colors']);
                    })
                        ->when($filters['sizes'], function (Builder $query) use ($filters) {
                            $query->whereIn('size_attribute_id', $filters['sizes']);
                        });
                });
            })

            ->when($filters['price_min'], function (Builder $query) use ($filters) {
                $query->where('price', '>=', $filters['price_min']);
            })

            ->when($filters['price_max'], function (Builder $query) use ($filters) {
                $query->where('price', '<=', $filters['price_max']);
            })

            ->when($filters['offer'], function (Builder $query) use ($filters) {
                $query->where('offer', '>=', $filters['offer']);
            })
            ->when($filters['attributes'], function (Builder $query) use ($filters) {

                $attribute_values = collect($filters['attributes']);

                $query->whereHas('presentations', function ($query) use ($attribute_values) {
                    $query->withCount(['attribute_values' => function ($query) use ($attribute_values) {
                        $query->whereIn('id', $attribute_values->collapse());
                    }])->where('attribute_values_count', '>=', count($attribute_values));
                });
            })

            ->when($filters['sortBy'], function (Builder $query) use ($filters) {
                $sorBy = $filters['sortBy'] == 'price_desc' ? 'desc' : 'asc';
                $query->orderBy('products.price', $sorBy);
            }, function ($query) {
                $query->orderBy('products.id', 'desc');
            });
    }
}
