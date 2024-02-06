<?php

namespace App\Http\Livewire\Blog;

use App\Models\Author;
use App\Models\Blog;
use App\Models\Category;
use App\Traits\TraitUploadImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    use TraitUploadImage, WithFileUploads;

    public $label = 'Post';

    public $labelPlural = 'Posts';

    public $edit = false;

    public $authors;

    public $categories;

    public Blog $post;

    public $thum;

    public $img;

    protected $rules = [
        'post.title' => 'required|string|max:255',
        'post.slug' => 'required|string|max:255|unique:blog,slug',
        'post.meta_title' => 'required|string|max:255',
        'post.meta_desc' => 'required|string|max:255',
        'post.entry' => 'required|string|max:255',
        'post.desc' => 'required|string',
        'post.active' => 'required|numeric|min:0',
        'post.author_id' => 'required|numeric|min:0',
        'post.category_id' => 'required|numeric|min:0',
        'thum' => 'nullable|sometimes|image|max:2024|mimes:jpeg,jpg,png',
        'img' => 'nullable|sometimes|image|max:2024|mimes:jpeg,jpg,png',
    ];

    public function mount($id = null)
    {
        $this->categories = Category::where('type', 'blog')->get();
        $this->authors = Author::get();
        $this->edit = boolval($id);

        if ($id) {
            $this->post = Blog::findOrFail($id);
        } else {
            //$this->post = new Blog();
            $this->post = Blog::factory()->make();
            $this->post->category_id = $this->categories->random()->id;
            $this->post->author_id = $this->authors->random()->id;
        }
    }

    public function save()
    {
        $this->rules['thum'] = "required|sometimes|image|max:2024|mimes:jpeg,jpg,png";
        $this->rules['img'] = "required|sometimes|image|max:2024|mimes:jpeg,jpg,png";
        //dd($this->post);
        $this->validate();
        DB::transaction(function () {

            $blog = $this->post;
            if ($this->thum) {
                //Storage::delete($blog->thum);
                $blog->thum = $this->upload_image($this->post->title, 'posts/thum', $this->thum);
            }

            if ($this->img) {
                //Storage::delete($blog->img);
                $blog->img = $this->upload_image($this->post->title, 'posts', $this->img);
            }

            $blog->save();
        });

        return redirect()->route('dashboard.posts')->with('success', 'Registro Guardados');
    }

    public function update()
    {
        $this->rules['post.slug'] = 'required|unique:blog,slug,' . $this->post->id . ',id';
        $this->validate();
        $blog = $this->post;

        if ($this->thum) {
            if ($blog->thum) {
                Storage::delete($blog->thum);
            }
            $blog->thum = $this->upload_image($this->post->title, 'posts/thum', $this->thum);
        }

        if ($this->img) {
            if ($blog->img) {
                Storage::delete($blog->img);
            }
            $blog->img = $this->upload_image($this->post->title, 'posts', $this->img);
        }

        $blog->save();

        return redirect()->route('dashboard.posts')->with('success', 'Registro Editado');
    }

    public function updateThum(): void
    {
        $this->validate([
            'thum' => 'image|max:1024|mimes:jpeg,jpg,png',
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
        return view('livewire.blog.create-post');
    }
}
