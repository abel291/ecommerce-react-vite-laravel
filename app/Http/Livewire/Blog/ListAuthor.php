<?php

namespace App\Http\Livewire\Blog;

use App\Models\Author;
use App\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class ListAuthor extends Component
{
    use WithPagination;
    use WithSorting;

    public $label = 'Autor';

    public $labelPlural = 'Autores';

    protected $queryString = ['sortBy', 'sortDirection', 'search'];

    protected $listeners = [
        'renderListAuthor' => 'render',
        'resetListAuthor' => 'resetList',
    ];

    public function render()
    {
        $list = Author::where(function ($query) {
            $query->orWhere('name', 'like', "%$this->search%");
            $query->orWhere('email', 'like', "%$this->search%");
            $query->orWhere('bio', 'like', "%$this->search%");
        })

            ->withCount('posts')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(20);

        return view('livewire.blog.list-author', compact('list'));
    }
}
