<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class ShowUser extends Component
{
    public $label;

    public $labelPlural;

    public $user;

    public function show(User $user)
    {
        //dd($user->created_at->isoFormat('ddd DD MMM YYYY hh:mm A'));
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.user.show-user');
    }
}
