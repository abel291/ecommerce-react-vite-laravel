<?php

namespace App\Http\Livewire\Brand;

use App\Models\Image;
use App\Models\Brand;
use App\Traits\WithSorting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class ListBrand extends Component
{
	use WithPagination;
	use WithSorting;
	public $label = "Marca";
	public $labelPlural = "Marcas";
	protected $queryString = ['sortBy', 'sortDirection', 'search'];
	protected $listeners = [
		'renderListBrand' => 'render',
		'resetListBrand' => 'resetList',
	];



	public function render()
	{
		$list = Brand::where(function ($query) {
			$query->orWhere('name', 'like', "%$this->search%");
			$query->orWhere('slug', 'like', "%$this->search%");
			$query->orWhere('website', 'like', "%$this->search%");
		})

			->withCount('products')
			->orderBy($this->sortBy, $this->sortDirection)
			->paginate(20);
		return view('livewire.brand.list-brand', compact('list'));
	}
}
