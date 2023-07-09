<?php

namespace App\Http\Livewire\DiscountCode;

use App\Models\DiscountCode;
use Livewire\Component;

class CreateDiscountCode extends Component
{
    public $label;

    public $labelPlural;

    public $productId;

    public $open = false;

    public DiscountCode $discountCode;

    public $open_modal_confirmation_delete = false;

    protected $rules = [
        'discountCode.name' => 'required|string|max:255',
        'discountCode.entry' => 'required|',
        'discountCode.code' => 'required|string|max:8|unique:discount_codes,code',
        'discountCode.value' => 'required|numeric|min:0|max:255',
        'discountCode.type' => 'required|string|max:255',
        'discountCode.start_date' => 'required|date_format:Y-m-d|before:discountCode.end_date',
        'discountCode.end_date' => 'required|date_format:Y-m-d|after:discountCode.start_date',
        'discountCode.active' => 'required|boolean',
    ];

    public function mount()
    {
        $this->discountCode = new DiscountCode;
    }

    public function create()
    {
        $this->discountCode = DiscountCode::factory()->make();
        $this->resetErrorBag();
    }

    public function save()
    {

        $this->validate();

        $discountCode = $this->discountCode;
        $discountCode->save();

        $this->emit('renderListDiscountCode');

        $this->dispatchBrowserEvent('notification', [
            'title' => "$this->label Agregado",
            'subtitle' => "$this->label  <b>".$this->discountCode->code.'</b>  fue  Agregado correctamente',
        ]);
        $this->open = false;
    }

    public function edit(DiscountCode $discountCode)
    {
        $this->discountCode = $discountCode;
        $this->resetErrorBag();
    }

    public function update()
    {
        $this->rules['discountCode.code'] = 'required|string|max:8|unique:discount_codes,code,'.$this->discountCode->id.',id';
        $this->validate();
        $discountCode = $this->discountCode;
        $discountCode->save();

        $this->emit('renderListDiscountCode');
        $this->dispatchBrowserEvent('notification', [
            'title' => "$this->label Agregado",
            'subtitle' => "$this->label  <b>".$this->discountCode->code.'</b>  fue  editado correctamente',
        ]);
        $this->open = false;
    }

    public function delete(DiscountCode $discountCode)
    {
        $name = $discountCode->code;

        $discountCode->delete();

        $this->open_modal_confirmation_delete = false;

        $this->emit('renderListDiscountCode');
        $this->dispatchBrowserEvent('notification', [
            'title' => "$this->label Eliminado",
            'subtitle' => "El registro  <b> $this->label :".$name.'</b>  fue quitado de la lista',
        ]);
    }

    public function render()
    {
        return view('livewire.discount-code.create-discount-code');
    }
}
