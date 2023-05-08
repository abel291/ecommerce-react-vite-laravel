<?php

namespace App\Http\Livewire\Category;

use App\Models\Category;
use App\Traits\TraitUploadImage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class CreateCategory extends Component
{
	use TraitUploadImage;
	use WithFileUploads;

	public $label = "Categoria";

	public $labelPlural = "Categorias";

	public $open = false;
	public $img;

	public Category $category;

	public $open_modal_confirmation_delete = false;

	protected $rules = [
		'category.name' => 'required|string|max:255',
		'category.slug' => 'required|string|max:255|unique:categories,slug',
		'category.entry' => 'required|string|max:255',
		'category.active' => 'required|boolean',
		'category.type' => 'required|string|max:255',
		'category.specifications.*' => 'string|max:255',
		'img' => 'nullable|sometimes|image|max:2024|mimes:jpeg,jpg,png',
	];
	public $data = [];


	public function mount()
	{
		$this->category = new Category;
		$this->category->specifications = array_fill(0, 9, '');
	}

	public function create()
	{
		$this->category = Category::factory()->make();
		//$this->category->specifications = array_fill(0, 9, '');
		$this->resetErrorBag();
	}

	public function save()
	{
		$this->validate();
		$category = $this->category;

		if ($this->img) {
			$category->img = $this->upload_image($this->category->name, 'categories', $this->img);
		}

		$category->specifications = array_filter($category->specifications, fn ($i) => $i != "");
		$category->save();

		$this->emit('resetListCategory');
		$this->dispatchBrowserEvent('notification', [
			'title' => "$this->label Agregado",
			'subtitle' => "$this->label  <b>" . $this->category->name . "</b>  fue  Agregado correctamente",
		]);
		$this->open = false;
	}

	public function edit(Category $category)
	{
		$this->category = $category;
		$this->category->specifications = array_pad($this->category->specifications, 9, '');
		$this->resetErrorBag();
	}

	public function update()
	{

		$this->rules['category.slug'] = 'required|unique:categories,slug,' . $this->category->id . ',id';
		$this->validate();

		$category = $this->category;

		if ($this->category->type == 'blog') {
			$this->category->specifications = [];
		} else {
			$category->specifications = array_filter($category->specifications, fn ($i) => $i != "");
		}

		if ($this->img) {
			Storage::delete($category->img);
			$category->img = $this->upload_image($this->category->name, 'categories', $this->img);
		}

		$category->save();

		$this->reset('img');
		$this->emit('renderListCategory');
		$this->dispatchBrowserEvent('notification', [
			'title' => 'Registro Editado',
			'subtitle' => '',
		]);
		$this->open = false;
	}

	public function delete(Category $category)
	{
		$name = $category->name;
		if ($category->img) {
			Storage::delete($category->img);
		}

		$category->delete();

		$this->open_modal_confirmation_delete = false;
		$this->emit('renderListCategory');
		$this->dispatchBrowserEvent('notification', [
			'title' => "$this->label Eliminado",
			'subtitle' => "El registro  <b> $this->label :" . $name . '</b>  fue quitado de la lista',
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
		return view('livewire.category.create-category');
	}
}
