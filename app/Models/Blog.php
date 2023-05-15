<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Blog extends Model
{
	use HasFactory;
	protected $table = 'blog';
	public function category(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}
	public function author(): BelongsTo
	{
		return $this->belongsTo(Author::class);
	}
}
