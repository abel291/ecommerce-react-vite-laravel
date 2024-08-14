<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Models\Attribute;
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
        $query->select('id', 'slug', 'thumb', 'name', 'offer', 'price', 'old_price', 'department_id', 'category_id');
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
            // ->when($filters['q'], function (Builder $query) use ($filters) {
            //     $query->where(function ($query) use ($filters) {
            //         $query->orWhere('name', 'like', '%' . $filters['q'] . '%');
            //         $query->orWhere('slug', 'like', '%' . $filters['q'] . '%');
            //         $query->orWhere('description_min', 'like', '%' . $filters['q'] . '%');
            //     });
            // })
            ->when($filters['departments'], function (Builder $query) use ($filters) {

                $query->whereHas('department', function (Builder $sub_query) use ($filters) {
                    $sub_query->where('name', $filters['departments'][0]);
                });
            })

            ->when($filters['categories'], function (Builder $query) use ($filters) {
                $query->whereHas('category', function (Builder $sub_query) use ($filters) {
                    $sub_query->where('name', $filters['categories'][0]);
                });
            })

            // ->when($filters['brands'], function (Builder $query) use ($filters) {
            //     $query->whereHas('brand', function (Builder $sub_query) use ($filters) {
            //         $sub_query->whereIn('name', $filters['brands']);
            //     });
            // })

            // ->when($filters['price_min'], function (Builder $query) use ($filters) {
            //     $query->where('price', '>=', $filters['price_min']);
            // })

            // ->when($filters['price_max'], function (Builder $query) use ($filters) {
            //     $query->where('price', '<=', $filters['price_max']);
            // })

            // ->when($filters['offer'], function (Builder $query) use ($filters) {
            //     $query->where('offer', '>=', $filters['offer']);
            // })
            ->when($filters['attributes'], function (Builder $query) use ($filters) {

                $attribute_values = collect($filters['attributes'])->values()->toArray();

                $attribute_values_id = AttributeValue::whereIn('name', $attribute_values)->pluck('id')->toArray();

                $query->whereHas('presentations', function ($query) use ($attribute_values_id) {
                    $query->withCount([
                        'attribute_values' => function ($query) use ($attribute_values_id) {
                            $query->whereIn('id', $attribute_values_id);
                        }
                    ])->where('attribute_values_count', '>=', count($attribute_values_id))
                    ;
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
