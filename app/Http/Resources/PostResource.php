<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id' => $this->id,
			'title' => $this->title,
			'slug' => $this->slug,
			'meta_title' => $this->meta_title,
			'meta_desc' => $this->meta_desc,
			'entry' => $this->entry,
			'desc' => $this->desc,
			'active' => $this->active,
			'img' => $this->img,
			'categories' => $this->whenLoaded('categories'),
			'created_at' => $this->created_at->format('Y/m/d'),
			'dateRelative' => $this->updated_at->locale('es_ES')->diffForHumans(['parts' => 2]),
		];
	}
}
