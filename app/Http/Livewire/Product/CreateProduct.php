<?php

namespace App\Http\Livewire\Product;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Specification;
use App\Models\Stock;
use App\Traits\TraitUploadImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateProduct extends Component
{
    use TraitUploadImage, WithFileUploads;

    public $label = 'Producto';

    public $labelPlural = 'Productos';

    public $edit = false;

    public $categories;

    public $brands;

    public Product $product;

    public Stock $stock;

    public $thum;

    public $img;

    protected $rules = [
        'product.name' => 'required|string|max:255',
        'product.slug' => 'required|string|max:255|unique:products,slug',
        'product.description_min' => 'required|string|max:255',
        'product.description_max' => 'required|string',
        'product.max_quantity' => 'required|integer|min:0',
        'product.price' => 'required|numeric|min:0',
        'product.offer' => 'required|numeric|min:0',
        'product.cost' => 'required|numeric|min:0',
        'product.active' => 'required',

        'stock.quantity' => 'required',
        'stock.remaining' => 'required',
        'stock.supplier' => 'required',
        'stock.barcode' => 'required',

        'product.category_id' => 'required|max:255',
        'product.brand_id' => 'required|max:255',

        'thum' => 'nullable|sometimes|image|max:2024|mimes:jpeg,jpg,png',
        'img' => 'nullable|sometimes|image|max:2024|mimes:jpeg,jpg,png',
    ];

    public function mount($id = null)
    {
        $this->categories = Category::where('type', 'product')->get();
        $this->brands = Brand::all();
        $this->edit = boolval($id);
        if ($id) {
            $this->product = Product::with('stock')->findOrFail($id);
            $this->stock = $this->product->stock;
        } else {
            //$this->product = new Product();
            $this->product = Product::factory()->make();
            $this->stock = Stock::factory()->make();
            $this->product->category_id = $this->categories->random()->id;
        }
    }

    public function save()
    {
        //$this->rules['thum'] = "required|sometimes|image|max:2024|mimes:jpeg,jpg,png";
        //$this->rules['img'] = "required|sometimes|image|max:2024|mimes:jpeg,jpg,png";
        //dd($this->product);
        $this->validate();
        DB::transaction(function () {

            $product = $this->product;
            $product->calculateOffer();

            if ($this->thum) {
                //Storage::delete($product->thum);
                $product->thum = $this->upload_image($this->product->name, 'products/thum', $this->thum);
            }

            if ($this->img) {
                //Storage::delete($product->img);
                $product->img = $this->upload_image($this->product->name, 'products', $this->img);
            }

            $product->save();

            $product->stock()->save($this->stock);

            $categories = $product->category;

            foreach ($categories->specifications as $specification_name) {
                Specification::create([
                    'name' => $specification_name,
                    'product_id' => $product->id,
                ]);
            }
        });

        return redirect()->route('dashboard.products')->with('success', 'Registro Guardados');
    }

    public function update()
    {
        $this->rules['product.slug'] = 'required|unique:products,slug,'.$this->product->id.',id';
        $this->validate();
        $product = $this->product;
        $product->price_offer = $product->calculateOffer();
        $stock = $this->stock;

        if ($this->thum) {
            if ($product->thum) {
                Storage::delete($product->thum);
            }
            $product->thum = $this->upload_image($this->product->name, 'products/thum', $this->thum);
        }

        if ($this->img) {
            if ($product->img) {
                Storage::delete($product->img);
            }
            $product->img = $this->upload_image($this->product->name, 'products', $this->img);
        }

        $product->save();

        $stock->save();

        return redirect()->route('dashboard.products')->with('success', 'Registro Editado');
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
        return view('livewire.product.create-product');
    }
}
