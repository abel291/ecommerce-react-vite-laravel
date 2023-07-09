<?php

namespace App\Http\Livewire\Image;

use App\Models\Image;
use App\Traits\TraitUploadImage;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateImage extends Component
{
    use TraitUploadImage, WithFileUploads;

    public $label;

    public $labelPlural;

    public $modelName;

    public $modelId;

    public $nameImage = '';

    public $open = false;

    public Image $image;

    public $img;

    public $open_modal_confirmation_delete = false;

    protected $rules = [
        'image.alt' => 'required|string|max:255',
        'image.title' => 'required|string|max:255',
        'image.sort' => 'required|numeric',
        'image.active' => 'required|boolean',
        'img' => 'nullable|sometimes|image|max:2024|mimes:jpeg,jpg,png',
    ];

    public function mount()
    {
        $this->image = new Image();
        $modelData = $this->modelName::find($this->modelId);
        switch (class_basename($modelData)) {
            case 'Product':
            case 'Page':
                $this->nameImage = $modelData->name;
                break;

            default:
                // code...
                break;
        }
    }

    public function create()
    {

        $this->image = Image::factory()->make();
        $this->resetErrorBag();
        $this->reset('img');
    }

    public function save()
    {
        $this->rules['img'] = 'required|sometimes|image|max:2024|mimes:jpeg,jpg,png';
        $this->validate();
        $image = $this->image;
        $image->imageable_id = $this->modelId;
        $image->imageable_type = $this->modelName;
        $image->img = $this->upload_image($this->nameImage, 'images', $this->img);
        $image->save();

        $this->emit('renderListImage');
        $this->dispatchBrowserEvent('notification', [
            'title' => "$this->label Agregado",
            'subtitle' => "El Registro  <b> $this->label:".$this->image->img.'</b>  fue  Agregado correctamente',
        ]);
        $this->open = false;
    }

    public function edit(Image $image)
    {
        $this->image = $image;
        $this->resetErrorBag();
        $this->reset('img');
    }

    public function update()
    {

        $this->validate();
        $image = $this->image;
        if ($this->img) {
            Storage::delete($image->img ?? '');
            $image->img = $this->upload_image($this->nameImage, 'images', $this->img);
        }

        $image->save();

        $this->emit('renderListImage');
        $this->dispatchBrowserEvent('notification', [
            'title' => "$this->label Agregado",
            'subtitle' => "El Registro  <b> $this->label:".$this->image->img.'</b>  fue  Editado correctamente',
        ]);
        $this->open = false;
    }

    public function delete(Image $image)
    {
        $name = $image->img;

        $image->delete();

        $this->open_modal_confirmation_delete = false;

        $this->emit('renderListImage');
        $this->dispatchBrowserEvent('notification', [
            'title' => 'Registro Eliminado',
            'subtitle' => "El registro  <b> $this->label :".$name.'</b>  fue quitado de la lista',
        ]);
    }

    public function updateImg(): void
    {
        $this->validate([
            'img' => 'image|max:1024|mimes:jpeg,jpg,png',
        ]);
    }

    public function render()
    {

        return view('livewire.image.create-image');
    }
}
