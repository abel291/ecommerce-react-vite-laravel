<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
	use HasFactory;

	protected $fillable = [
		'name',
		'slug',
		'type',
	];

	public function product()
	{
		return $this->belongsTo(Product::class,);
	}

	public function category()
	{
		return $this->belongsTo(Product::class,);
	}
}
