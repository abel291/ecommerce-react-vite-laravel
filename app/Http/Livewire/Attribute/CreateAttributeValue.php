<?php

namespace App\Http\Livewire\Attribute;

use App\Models\AttributeValue;
use App\Models\Attribute;
use Livewire\Component;
use Illuminate\Support\Str;

class CreateAttributeValue extends Component
{

	public $label;

	public $labelPlural;

	public $productId;

	public $attributes;

	public $open = false;

	public AttributeValue $attribute_value;

	public $open_modal_confirmation_delete = false;

	protected $rules = [
		'attribute_value.name' => 'required|string|max:255',
		'attribute_value.in_stock' => 'required|boolean',
		'attribute_value.default' => 'required|boolean',
		'attribute_value.attribute_id' => 'required|integer',
	];

	public function mount()
	{
		$this->attribute_value = new AttributeValue();
		$this->attributes = Attribute::where('product_id', $this->productId)->get();
	}

	public function create()
	{
		$this->attribute_value = new AttributeValue();
		$this->attributes = Attribute::where('product_id', $this->productId)->get();
		$this->resetErrorBag();
	}

	public function save()
	{

		$this->validate();
		$attribute_value = $this->attribute_value;
		$attribute_value->slug = Str::slug($this->attribute_value->name);
		$attribute_value->product_id = $this->productId;
		$attribute_value->save();

		if ($attribute_value->default) {
			AttributeValue::where('attribute_id', $attribute_value->attribute_id)
				->where('id', '!=', $attribute_value->id)->update(['default' => false]);
		}

		$this->emit('renderListAttributess');
		$this->dispatchBrowserEvent('notification', [
			'title' => "$this->label Agregado",
			'subtitle' => "$this->label  <b>" . $this->attribute_value->name . '</b>  fue  Agregado correctamente',
		]);
		$this->open = false;
	}

	public function edit(AttributeValue $attribute_value)
	{

		$this->attribute_value = $attribute_value;
		$this->attributes = Attribute::where('product_id', $this->productId)->get();
		$this->resetErrorBag();
	}

	public function update()
	{
		$this->validate();

		$attribute_value = $this->attribute_value;
		$attribute_value->slug = Str::slug($this->attribute_value->name);
		$attribute_value->product_id = $this->productId;
		$attribute_value->save();

		if ($attribute_value->default) {
			AttributeValue::where('attribute_id', $attribute_value->attribute_id)
				->where('id', '!=', $attribute_value->id)->update(['default' => false]);
		}

		$this->emit('renderListAttributess');
		$this->dispatchBrowserEvent('notification', [
			'title' => "$this->label Agregado",
			'subtitle' => "$this->label  <b>" . $this->attribute_value->code . '</b>  fue  editado correctamente',
		]);
		$this->open = false;
	}

	public function delete(AttributeValue $attribute_value)
	{
		$name = $attribute_value->name;

		$attribute_value->delete();

		$this->open_modal_confirmation_delete = false;

		$this->emit('renderListAttribute');
		$this->dispatchBrowserEvent('notification', [
			'title' => "$this->label Eliminado",
			'subtitle' => "El registro  <b> $this->label :" . $name . '</b>  fue quitado de la lista',
		]);
	}
	public function render()
	{
		return view('livewire.attribute.create-attribute-value');
	}
}
