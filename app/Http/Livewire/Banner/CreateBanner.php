<?php

namespace App\Http\Livewire\Banner;

use App\Models\Image;
use App\Traits\TraitUploadImage;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateBanner extends Component
{
    use TraitUploadImage;
    use WithFileUploads;

    public $label;

    public $labelPlural;

    public $open = false;

    public $img;

    public Image $image;

    public $open_modal_confirmation_delete = false;

    protected $rules = [
        'image.title' => 'required|string|max:255',
        'image.alt' => 'required|string|max:255|unique:categories,slug',
        'image.sort' => 'required|string|max:255',
        'image.link' => 'required|string|max:255',
        'image.active' => 'required|boolean',
        'img' => 'nullable|sometimes|image|max:2024|mimes:jpeg,jpg,png',
    ];

    public function mount()
    {
        $this->image = new Image();
        $this->image->specifications = array_fill(0, 9, '');
    }

    // public function create()
    // {
    // 	$this->image = Image::factory()->make();
    // 	//$this->image->specifications = array_fill(0, 9, '');
    // 	$this->resetErrorBag();
    // }

    // public function save()
    // {
    //
    // }

    public function edit(Image $image)
    {
        $this->image = $image;
        $this->reset('img');
        $this->resetErrorBag();
    }

    public function update()
    {

        $this->validate();
        $image = $this->image;

        if ($this->img) {
            Storage::delete($image->img);
            $image->img = $this->upload_image($this->image->title, 'banners', $this->img);
        }

        $image->save();

        $this->reset('img');
        $this->emit('renderListImage');
        $this->dispatchBrowserEvent('notification', [
            'title' => 'Registro Editado',
            'subtitle' => "El registro  <b> $this->label :</b>  fue editado",
        ]);
        $this->open = false;
    }

    // public function delete(Image $image)
    // {
    // 	$name = $image->img;
    // 	if ($image->img) {
    // 		Storage::delete($image->img);
    // 	}

    // 	$image->delete();

    // 	$this->reset('img');
    // 	$this->open_modal_confirmation_delete = false;
    // 	$this->emit('renderListImage');
    // 	$this->dispatchBrowserEvent('notification', [
    // 		'title' => "$this->label Eliminado",
    // 		'subtitle' => "El registro  <b> $this->label :" . $name . '</b>  fue quitado de la lista',
    // 	]);
    // }
    public function updateImg(): void
    {
        $this->validate([
            'img' => 'image|max:1024|mimes:jpeg,jpg,png',
        ]);
    }

    public function render()
    {
        return view('livewire.banner.create-banner');
    }
}
