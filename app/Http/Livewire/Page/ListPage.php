<?php

namespace App\Http\Livewire\Page;

use App\Models\Page;
use App\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class ListPage extends Component
{
    use WithPagination;
    use WithSorting;

    public $label = 'Pagina';

    public $labelPlural = 'Paginas';

    protected $queryString = ['sortBy', 'sortDirection', 'search'];

    protected $listeners = [
        'renderListPage' => 'render',
        'resetListPage' => 'resetList',
    ];

    public function render()
    {
        $list = Page::with('banners')->where(function ($query) {
            $query->orWhere('type', 'like', "%$this->search%");
            $query->orWhere('meta_title', 'like', "%$this->search%");
            $query->orWhere('meta_desc', 'like', "%$this->search%");
        })

            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(20);

        return view('livewire.page.list-page', compact('list'));
    }
}
