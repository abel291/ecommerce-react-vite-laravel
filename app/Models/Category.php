<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

	public function products()
	{
		return $this->hasMany(Product::class);
	}

	// public function specifications()
	// {
	// 	return $this->hasMany(Specification::class);
	// }
}
