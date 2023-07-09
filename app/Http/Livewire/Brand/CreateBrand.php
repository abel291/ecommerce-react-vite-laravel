<?php

namespace App\Http\Livewire\Brand;

use App\Models\Brand;
use App\Traits\TraitUploadImage;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateBrand extends Component
{
    use TraitUploadImage;
    use WithFileUploads;

    public $label;

    public $labelPlural;

    public $open = false;

    public $img;

    public Brand $brand;

    public $open_modal_confirmation_delete = false;

    protected $rules = [
        'brand.name' => 'required|string|max:255',
        'brand.slug' => 'required|string|max:255|unique:brands,slug',
        'brand.website' => 'required|string|max:255',
        'brand.active' => 'required|boolean',
        'img' => 'nullable|sometimes|image|max:2024|mimes:jpeg,jpg,png',
    ];

    public function mount()
    {
        $this->brand = new Brand;
    }

    public function create()
    {
        $this->brand = Brand::factory()->make();
        $this->resetErrorBag();
        $this->reset('img');
    }

    public function save()
    {
        $this->validate();
        $brand = $this->brand;

        if ($this->img) {
            $brand->img = $this->upload_image($this->brand->name, 'brands', $this->img);
        }
        $brand->save();

        $this->emit('renderListBrand');
        $this->dispatchBrowserEvent('notification', [
            'title' => "$this->label Agregado",
            'subtitle' => "$this->label  <b>".$this->brand->name.'</b>  fue  Agregado correctamente',
        ]);
        $this->open = false;
    }

    public function edit(Brand $brand)
    {
        $this->brand = $brand;
        $this->resetErrorBag();
        $this->reset('img');
    }

    public function update()
    {

        $this->rules['brand.slug'] = 'required|unique:brands,slug,'.$this->brand->id.',id';
        $this->validate();

        $brand = $this->brand;

        if ($this->img) {
            Storage::delete($brand->img);
            $brand->img = $this->upload_image($this->brand->name, 'brands', $this->img);
        }

        $brand->save();

        $this->reset('img');

        $this->emit('renderListBrand');
        $this->dispatchBrowserEvent('notification', [
            'title' => 'Registro Editado',
            'subtitle' => '',
        ]);
        $this->open = false;
    }

    public function delete(Brand $brand)
    {
        $name = $brand->name;
        if ($brand->img) {
            Storage::delete($brand->img);
        }

        $brand->delete();

        $this->open_modal_confirmation_delete = false;
        $this->emit('renderListBrand');
        $this->dispatchBrowserEvent('notification', [
            'title' => "$this->label Eliminado",
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
        return view('livewire.brand.create-brand');
    }
}
