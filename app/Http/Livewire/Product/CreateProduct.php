<?php

namespace App\Http\Livewire\Product;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use App\Traits\TraitUploadImage;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Contracts\Role;

class CreateProduct extends Component
{
	use TraitUploadImage, WithFileUploads;

	public $label = "Producto";

	public $labelPlural = "Productos";

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
		'product.price' => 'required|integer|min:0',
		'product.offer' => 'required|max:255',
		'product.cost' => 'required|max:255',
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

		$this->validate();
		$product = $this->product;
		if ($product->offer) {
			$product->price_offer = $product->price - ($product->price * ($product->offer / 100));
		} else {
			$product->price_offer = $product->price;
		}

		if ($this->thum) {
			//Storage::delete($product->thum);
			$product->thum = $this->upload_image($this->product->name, 'products/thum', $this->thum);
		}

		if ($this->img) {
			//Storage::delete($product->img);
			$product->redes = $this->upload_image($this->product->nombre, 'products', $this->redes);
		}

		$this->stock->remaining = $this->stock->quantity;

		$product->save();

		$product->stock()->save($this->stock);

		return redirect()->route('dashboard.products')->with('success', 'Registro Guardados');
	}

	public function edit(Product $product)
	{
		$this->product = $product;
		$this->role = $this->product->getRoleNames()->first();
		$this->resetErrorBag();
	}

	public function update()
	{
		$this->rules['user.email'] = 'required|email|unique:users,email,' . $this->product->id . ',id';
		$this->rules['password'] = 'sometimes|string|min:6|max:200|confirmed';

		$this->validate();

		$product = $this->product;

		if ($this->thum) {
			Storage::delete($product->thum);
			$product->thum = $this->upload_image($this->product->name, 'products/thum', $this->thum);
		}

		if ($this->img) {
			Storage::delete($product->img);
			$product->redes = $this->upload_image($this->product->nombre, 'products', $this->redes);
		}

		$product->save();

		// $this->reset('password', 'password_confirmation');
		$this->emit('renderListProduct');
		$this->dispatchBrowserEvent('notification', [
			'title' => 'Registro Editado',
			'subtitle' => '',
		]);
		$this->open = false;
	}

	public function delete(Product $product)
	{
		$name = $product->name;
		$product->removeRole('admin');
		$this->open_modal_confirmation_delete = false;
		$product->delete();

		$this->emit('renderListProduct');
		$this->dispatchBrowserEvent('notification', [
			'title' => 'Usuario Eliminado',
			'subtitle' => 'El usuario  <b>' . $name . '</b>  fue quitado de la lista',
		]);
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
