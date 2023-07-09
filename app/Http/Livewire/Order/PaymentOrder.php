<?php

namespace App\Http\Livewire\Order;

use App\Enums\PaymentStatus;
use App\Services\PaymentService;
use Livewire\Component;

class PaymentOrder extends Component
{
    public $order;

    public $code_reference;

    public $refunded = 0;

    public $open = false;

    public $open_canceled = false;

    protected $rules = [
        'code_reference' => 'nullable|string|min:6|max:255',
        'refunded' => 'nullable|',
    ];

    public function approvePayment()
    {
        $this->rules['code_reference'] = 'required|string|min:6|max:255';
        $this->validate();
        $this->order->payment->code_reference = $this->code_reference;
        $this->order->payment->status = PaymentStatus::SUCCESSFUL;
        $this->order->payment->save();

        $this->reset('code_reference', 'open');
        $this->dispatchBrowserEvent('notification', [
            'title' => 'Referencia Agregada',
            'subtitle' => 'La referencia  <b>'.$this->order->payment->code_reference.'</b>  fue  Agregado correctamente',
        ]);
    }

    public function cancelPayment()
    {

        $this->rules['refunded'] = 'required|numeric|min:0|max:1';
        $this->validate();

        if ($this->refunded) {
            $this->order->payment->status = PaymentStatus::REFUNDED;
            PaymentService::refund($this->order);
        } else {
            $this->order->payment->status = PaymentStatus::CANCELED;
        }

        $this->order->payment->save();

        $this->reset('refunded', 'open_canceled');
        $this->dispatchBrowserEvent('notification', [
            'title' => 'Referencia Agregada',
            'subtitle' => 'La Orden  <b>'.$this->order->code.'</b>  fue  cancelada correctamente',
        ]);
    }

    public function render()
    {
        return view('livewire.order.payment-order');
    }
}
