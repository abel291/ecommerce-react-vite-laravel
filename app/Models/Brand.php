<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
	use HasFactory;

	protected $fillable = [
		'name',
		'slug',
		'img',
	];
	public function products()
	{
		return $this->hasMany(Product::class);
	}
	public function scopeActive(Builder $query): void
	{
		$query->where('active', 1);
	}
}
