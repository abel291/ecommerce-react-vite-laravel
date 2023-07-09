<?php

namespace App\Http\Livewire\Banner;

use App\Models\Image;
use App\Models\Page;
use App\Traits\WithSorting;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ListBanner extends Component
{
    use WithPagination;
    use WithSorting;

    public $label = 'Banner';

    public $labelPlural = 'Banners';

    public $open_modal_confirmation_delete = false;

    public $pages_list;

    public $pages_id;

    public function mount()
    {
        $this->pages_list = Page::select(['id', 'title'])->has('banners')->get();
    }

    protected $queryString = ['sortBy', 'sortDirection', 'search', 'page', 'pages_id'];

    protected $listeners = [
        'renderListImage' => 'render',
        'resetListImage' => 'resetList',
    ];

    // public function delete(Product $product)
    // {
    // 	$name = $product->name;
    // 	$product->images()->delete();
    // 	$product->delete();

    // 	$this->open_modal_confirmation_delete = false;
    // 	$this->emit('renderListProduct');
    // 	$this->dispatchBrowserEvent('notification', [
    // 		'title' => 'Regsitro Eliminado',
    // 		'subtitle' => 'El registro  <b>' . $name . '</b>  fue quitado de la lista',
    // 	]);
    // }
    public function render()
    {
        $list = Image::with('model')->where(function ($query) {
            $query->orWhere('title', 'like', "%$this->search%");
            $query->orWhere('alt', 'like', "%$this->search%");
            //$query->orWhere('description_max', 'like', "%$this->search%");
        })
            ->where('model_type', 'App\Models\Page')
            ->when($this->pages_id, function (Builder $query) {
                $query->where('model_id', $this->pages_id);
            })

            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(20);

        return view('livewire.banner.list-banner', compact('list'));
    }
}
