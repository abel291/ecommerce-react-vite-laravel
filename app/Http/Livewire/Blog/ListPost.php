<?php

namespace App\Http\Livewire\Blog;

use App\Models\Blog;
use App\Traits\WithSorting;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class ListPost extends Component
{
    use WithPagination;
    use WithSorting;

    public $label = 'Post';

    public $labelPlural = 'Posts';

    protected $queryString = ['sortBy', 'sortDirection', 'search'];

    public $open_modal_confirmation_delete = false;

    protected $listeners = [
        'renderListBlog' => 'render',
        'resetListBlog' => 'resetList',
    ];

    public function delete(Blog $post)
    {
        $name = $post->title;
        if ($post->img) {
            Storage::delete($post->img);
        }
        if ($post->thum) {
            Storage::delete($post->thum);
        }
        $post->delete();

        $this->open_modal_confirmation_delete = false;
        $this->emit('renderListProduct');
        $this->dispatchBrowserEvent('notification', [
            'title' => 'Regsitro Eliminado',
            'subtitle' => "El registro  $this->label: <b> $name </b>  fue quitado de la lista",
        ]);
    }

    public function render()
    {
        $list = Blog::where(function ($query) {
            $query->orWhere('title', 'like', "%$this->search%");
            $query->orWhere('slug', 'like', "%$this->search%");
            $query->orWhere('entry', 'like', "%$this->search%");
        })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(20);

        return view('livewire.blog.list-post', compact('list'));
    }
}
