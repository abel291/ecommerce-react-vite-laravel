<?php

namespace App\Models;

use App\Enums\PaymentStatus;



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

    protected $casts = [
        'price' => 'float',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class);
    }

    public function variantDefault()
    {
        return $this->hasOne(Variant::class)->orWhere('default', 1);
    }
    public function variant()
    {
        return $this->hasOne(Variant::class);
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
    public function scopeAvailable(Builder $query): void
    {
        $query->inStock();
    }

    public function scopeInStock(Builder $query, $colorSlug = null): void
    {
        $query->withWhereHas('variant', function ($query) use ($colorSlug) {

            $query->active()->whereRelation('sizes', 'stock', '>', 0)->orWhere('default', 1)

                ->withWhereHas('color', function ($query) use ($colorSlug) {

                    if ($colorSlug) {
                        $query->where('slug', $colorSlug);
                    }
                });
        });
    }

    public function scopeSelectForCard(Builder $query): void
    {
        $query->select(
            'products.id',
            'slug',
            'name',
            'offer',
            'price',
            'old_price',
            'department_id',
            'category_id'
        )
            ->with('variants.color');
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




    public function scopeWithFilters($query, $filters)
    {

        return $query
            ->selectForCard()

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

            ->when($filters['colors'] || $filters['sizes'], function (Builder $query) use ($filters) {

                $query->withWhereHas('variant', function ($query) use ($filters) {

                    $query->with('color')->when($filters['colors'], function ($query) use ($filters) {

                        $query->whereIn('color_id', $filters['colors']);
                    })
                        ->when($filters['sizes'], function ($query) use ($filters) {
                            $query->whereHas('sizesAvailable', function ($query) use ($filters) {
                                $query->whereIn('sizes.id', $filters['sizes']);
                            });
                        });
                });
            }, function ($query) {
                $query->inStock();
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
            // ->when($filters['attributes'], function (Builder $query) use ($filters) {

            //     $attribute_values = collect($filters['attributes']);

            //     $query->whereHas('presentations', function ($query) use ($attribute_values) {
            //         $query->withCount([
            //             'attribute_values' => function ($query) use ($attribute_values) {
            //                 $query->whereIn('id', $attribute_values->collapse());
            //             }
            //         ])->where('attribute_values_count', '>=', count($attribute_values));
            //     });
            // })
            ->when($filters['sortBy'], function (Builder $query) use ($filters) {
                $sorBy = $filters['sortBy'] == 'price_desc' ? 'desc' : 'asc';
                $query->orderBy('price', $sorBy);
            })
        ;
    }
}
