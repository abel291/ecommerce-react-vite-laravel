<?php

namespace App\Http\Livewire\Blog;

use App\Models\Author;
use App\Traits\TraitUploadImage;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateAuthor extends Component
{
    // name
    // email
    // bio
    // img
    // social1
    // social2
    use TraitUploadImage;
    use WithFileUploads;

    public $label;

    public $labelPlural;

    public $open = false;

    public $img;

    public Author $author;

    public $open_modal_confirmation_delete = false;

    protected $rules = [
        'author.name' => 'required|string|max:255',
        'author.position' => 'required|string|max:255',
        'author.email' => 'required|string|max:255|unique:authors,email',
        'author.bio' => 'required|string',
        'author.social1' => 'required|string|max:255',
        'author.social2' => 'required|string|max:255',
        'img' => 'nullable|sometimes|image|max:2024|mimes:jpeg,jpg,png',
    ];

    public function mount()
    {
        $this->author = new Author;
    }

    public function create()
    {
        $this->author = Author::factory()->make();
        $this->resetErrorBag();
        $this->reset('img');
    }

    public function save()
    {
        $this->rules['img'] = 'required|image|max:2024|mimes:jpeg,jpg,png';
        $this->validate();
        $author = $this->author;

        if ($this->img) {
            $author->img = $this->upload_image($this->author->name, 'authors', $this->img);
        }
        $author->save();

        $this->emit('renderListAuthor');
        $this->dispatchBrowserEvent('notification', [
            'title' => "$this->label Agregado",
            'subtitle' => "$this->label  <b>".$this->author->name.'</b>  fue  Agregado correctamente',
        ]);
        $this->open = false;
    }

    public function edit(Author $author)
    {
        $this->author = $author;
        $this->resetErrorBag();
        $this->reset('img');
    }

    public function update()
    {

        $this->rules['author.email'] = 'required|unique:authors,email,'.$this->author->id.',id';
        $this->validate();

        $author = $this->author;

        if ($this->img) {
            Storage::delete($author->img);
            $author->img = $this->upload_image($this->author->name, 'authors', $this->img);
        }

        $author->save();

        $this->reset('img');

        $this->emit('renderListAuthor');
        $this->dispatchBrowserEvent('notification', [
            'title' => 'Registro Editado',
            'subtitle' => '',
        ]);
        $this->open = false;
    }

    public function delete(Author $author)
    {
        $name = $author->name;
        if ($author->img) {
            Storage::delete($author->img);
        }

        $author->delete();
        $this->open_modal_confirmation_delete = false;
        $this->emit('renderListAuthor');
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
        return view('livewire.blog.create-author');
    }
}
