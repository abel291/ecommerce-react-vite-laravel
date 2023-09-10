<?php

namespace App\Http\Livewire\Specification;

use App\Models\Specification;
use Livewire\Component;

class CreateSpecification extends Component
{
	public $label;

	public $labelPlural;

	public $productId;

	public $open = false;

	public Specification $specification;

	public $open_modal_confirmation_delete = false;

	protected $rules = [
		'specification.type' => 'required|string|max:255',
		'specification.name' => 'required|string|max:255',
		'specification.value' => 'required|string|max:255',
		'specification.active' => 'required|boolean',
	];

	public function mount()
	{
		$this->specification = new Specification;
	}

	public function create()
	{
		$this->specification = Specification::factory()->make();
		$this->resetErrorBag();
	}

	public function save()
	{
		$this->validate();
		$specification = $this->specification;
		$specification->product_id = $this->productId;
		$specification->save();

		$this->emit('renderListSpecification');
		$this->dispatchBrowserEvent('notification', [
			'title' => "$this->label Agregado",
			'subtitle' => "$this->label  <b>" . $this->specification->name . '</b>  fue  Agregado correctamente',
		]);
		$this->open = false;
	}

	public function edit(Specification $specification)
	{
		$this->specification = $specification;
		$this->resetErrorBag();
	}

	public function update()
	{
		$this->save();
	}

	public function delete(Specification $specification)
	{
		$name = $specification->name;

		$specification->delete();

		$this->open_modal_confirmation_delete = false;

		$this->emit('renderListSpecification');
		$this->dispatchBrowserEvent('notification', [
			'title' => "$this->label Eliminado",
			'subtitle' => "El registro  <b> $this->label :" . $name . '</b>  fue quitado de la lista',
		]);
	}

	public function render()
	{
		return view('livewire.specification.create-specification');
	}
}
