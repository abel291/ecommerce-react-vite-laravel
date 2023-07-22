<?php

namespace App\Http\Livewire\Attribute;

use App\Models\Attribute;
use Livewire\Component;
use Illuminate\Support\Str;

class CreateAttribute extends Component
{
	public $label;

	public $labelPlural;

	public $productId;

	public $open = false;

	public Attribute $attribute;

	public $open_modal_confirmation_delete = false;

	protected $rules = [
		'attribute.name' => 'required|string|max:255',
	];

	public function mount()
	{
		$this->attribute = new Attribute();
	}

	public function create()
	{
		$this->attribute = new Attribute();
		$this->resetErrorBag();
	}

	public function save()
	{
		$this->validate();

		$attribute = $this->attribute;
		$attribute->slug = Str::slug($this->attribute->name);
		$attribute->product_id = $this->productId;
		$attribute->save();

		$this->emit('renderListAttributess');

		$this->dispatchBrowserEvent('notification', [
			'title' => "$this->label Agregado",
			'subtitle' => "$this->label  <b>" . $this->attribute->name . '</b>  fue  Agregado correctamente',
		]);
		$this->open = false;
		$this->mount();
	}

	public function edit(Attribute $attribute)
	{
		$this->attribute = $attribute;
		$this->resetErrorBag();
	}

	public function update()
	{
		$this->validate();
		$attribute = $this->attribute;
		$attribute->slug = Str::slug($this->attribute->name);
		$attribute->product()->associate($this->productId);
		$attribute->save();

		$this->emit('renderListAttributess');
		$this->dispatchBrowserEvent('notification', [
			'title' => "$this->label Agregado",
			'subtitle' => "$this->label  <b>" . $this->attribute->code . '</b>  fue  editado correctamente',
		]);
		$this->open = false;
		$this->mount();
	}

	public function delete(Attribute $attribute)
	{

		$name = $attribute->name;

		$attribute->delete();

		$this->open_modal_confirmation_delete = false;

		$this->emit('renderListAttributess');
		$this->dispatchBrowserEvent('notification', [
			'title' => "$this->label Eliminado",
			'subtitle' => "El registro  <b> $this->label :" . $name . '</b>  fue quitado de la lista',
		]);
		$this->mount();
	}
	public function render()
	{
		return view('livewire.attribute.create-attribute');
	}
}
