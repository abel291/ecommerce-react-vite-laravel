<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Payment;
use Livewire\Component;

class DashboardPayments extends Component
{
    public function render()
    {
        $payments = Payment::whereMonth('created_at', now()->month)->with('order.user')->orderBy('id', 'desc')->limit(10)->get();

        return view('livewire.dashboard.dashboard-payments', ['payments' => $payments]);
    }
}
