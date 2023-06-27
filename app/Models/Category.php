<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Category extends Model
{
	use HasFactory;

	protected $fillable = [
		'name',
		'slug',
		'img',
		'specifications',
	];

	protected $casts = [
		'specifications' => 'array',
	];

	public function products(): HasMany
	{
		return $this->hasMany(Product::class);
	}

	public function department_products(): HasMany
	{
		return $this->hasMany(Product::class, 'department_id');
	}

	public function categories(): HasMany
	{
		return $this->hasMany(Category::class);
	}
	public function department(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}

	public function posts(): HasMany
	{
		return $this->hasMany(Blog::class);
	}

	public function scopeWithFilters($query, $search)
	{
		//dd($search);
		return $query->when($search, function (Builder $query) use ($search) {
			$query->where('slug', $search);
		});
	}
	public function scopeActive(Builder $query): void
	{
		$query->where('active', 1);
	}

	// public function specifications()
	// {
	// 	return $this->hasMany(Specification::class);
	// }
}
