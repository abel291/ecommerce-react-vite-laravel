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
			'position' => $this->position,
			'slug' => $this->slug,
			'meta_title' => $this->meta_title,
			'meta_desc' => $this->meta_desc,
			'entry' => $this->entry,
			'desc' => $this->desc,
			'active' => $this->active,
			'img' => $this->img,
			'category' => $this->whenLoaded('category'),
			'author' => $this->whenLoaded('author'),
			'created_at' => $this->created_at->format('Y-m-d'),
			'date' => $this->created_at->isoFormat('dddd DD MMMM YYYY'),
			'dateRelative' => $this->updated_at->locale('es_ES')->diffForHumans(['parts' => 2]),
		];
	}
}
