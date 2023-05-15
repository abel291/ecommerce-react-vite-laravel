<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Routing\Controllers\HasMiddleware;

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

	public function posts(): HasMany
	{
		return $this->hasMany(Blog::class);
	}

	// public function specifications()
	// {
	// 	return $this->hasMany(Specification::class);
	// }
}
