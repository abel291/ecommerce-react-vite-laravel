<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends JsonResource<User>
 */
class UserResource extends JsonResource
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
			'name' => $this->name,
			'email' => $this->email,
			'phone' => $this->phone,
			'country' => $this->country,
			'city' => $this->city,
			'address' => $this->address,
			'role' => $this->getRoleNames()->first(),
			'updated_at' => $this->updated_at->format('Y/m/d'),
			'created_at' => $this->created_at->format('Y/m/d'),
			'dateRelative' => $this->updated_at->locale('es_ES')->diffForHumans(['parts' => 2]),
		];
	}
}
