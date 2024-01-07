<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class CreateUser extends Component
{
    public $label;

    public $labelPlural;

    // public $edit_var = false;

    public $open = false;

    public User $user;

    public $open_modal_confirmation_delete = false;

    public $password = '';

    public $password_confirmation = '';

    public $roles;

    public $role;

    protected $rules = [

        'user.name' => 'required|string|max:255',
        'user.email' => 'required|email|string|max:255|unique:users,email',
        'user.phone' => 'required|string|max:255',
        'user.country' => 'required|string|max:255',
        'user.city' => 'required|string|max:255',
        'user.address' => 'required|string|max:255',
        'role' => 'required|string|max:255',
        'password' => 'required|string|min:6|max:200|confirmed',
    ];

    public function mount()
    {
        $this->user = new User;
        $this->roles = Role::all();
    }

    public function create()
    {
        $this->user = User::factory()->make();
        $this->role = 'usuario';
        $this->resetErrorBag();
    }

    public function save()
    {

        $this->validate();
        $user = $this->user;
        $this->user->password = Hash::make($this->password);
        $this->user->assignRole($this->role);
        $user->save();

        $this->emit('resetListUser');
        $this->dispatchBrowserEvent('notification', [
            'title' => 'Usuario Agregado',
            'subtitle' => 'El usuario  <b>' . $this->user->name . '</b>  fue  Agregado correctamente',
        ]);
        $this->open = false;
    }

    public function edit(User $user)
    {
        $this->user = $user;
        $this->role = $this->user->getRoleNames()->first();
        $this->resetErrorBag();
    }

    public function update()
    {
        $this->rules['user.email'] = 'required|email|unique:users,email,' . $this->user->id . ',id';
        $this->rules['password'] = 'sometimes|string|min:6|max:200|confirmed';

        $this->validate();

        $user = $this->user;
        $this->user->assignRole($this->role);
        if ($this->password != '') {
            $user->password = Hash::make($this->password);
        }
        $user->save();

        // $this->reset('password', 'password_confirmation');
        $this->emit('renderListUser');
        $this->dispatchBrowserEvent('notification', [
            'title' => 'Registro Editado',
            'subtitle' => '',
        ]);
        $this->open = false;
    }

    public function delete(User $user)
    {
        $name = $user->name;
        $user->removeRole('admin');
        $this->open_modal_confirmation_delete = false;
        $user->delete();

        $this->emit('renderListUser');
        $this->dispatchBrowserEvent('notification', [
            'title' => 'Usuario Eliminado',
            'subtitle' => 'El usuario  <b>' . $name . '</b>  fue quitado de la lista',
        ]);
    }

    public function render()
    {
        return view('livewire.user.create-user');
    }
}
