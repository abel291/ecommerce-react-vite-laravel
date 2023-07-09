<?php

namespace App\Http\Livewire\Category;

use App\Models\Category;
use App\Traits\WithSorting;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ListCategory extends Component
{
    use WithPagination;
    use WithSorting;

    public $label = 'Categoria';

    public $labelPlural = 'Categorias';

    protected $queryString = ['sortBy', 'sortDirection', 'search'];

    protected $listeners = [
        'renderListCategory' => 'render',
        'resetListCategory' => 'resetList',
    ];

    public $type_category = '';

    public function render()
    {
        $list = Category::where(function ($query) {
            $query->orWhere('name', 'like', "%$this->search%");
            $query->orWhere('slug', 'like', "%$this->search%");
            $query->orWhere('entry', 'like', "%$this->search%");
        })
            ->when($this->type_category, function (Builder $query) {
                $query->where('type', $this->type_category);
            })

            ->withCount('products', 'posts')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(20);

        return view('livewire.category.list-category', compact('list'));
    }
}
