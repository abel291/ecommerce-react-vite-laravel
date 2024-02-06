<?php

namespace App\Http\Livewire\User;

use App\Models\Image;
use App\Models\User;
use App\Traits\WithSorting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class ListUser extends Component
{
    use WithPagination;
    use WithSorting;

    public $label = 'Usuario';

    public $labelPlural = 'Usuarios';

    // public $open_modal_confirmation_delete = false;
    protected $queryString = ['sortBy', 'sortDirection', 'search'];

    protected $listeners = [
        'renderListUser' => 'render',
        'resetListUser' => 'resetList',
    ];
    // public function delete(User $beneficiary)
    // {

    // 	DB::transaction(function () use ($beneficiary) {
    // 		if ($beneficiary->images) {
    // 			Image::destroy($beneficiary->images->pluck('id'));
    // 		}
    // 		Storage::delete($beneficiary->only(['image', 'card', 'social']));
    // 		$beneficiary->delete();
    // 	});

    // 	$this->open_modal_confirmation_delete = false;
    // 	$this->dispatchBrowserEvent('toast', [
    // 		'title' => 'Registro Eliminado',
    // 	]);
    // 	Cache::flush();
    // }

    public function render()
    {
        $list = User::where('name', 'like', '%' . $this->search . '%')
            ->whereNot('id', auth()->user()->id)
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(20);

        return view('livewire.user.list-user', compact('list'));
    }
}
