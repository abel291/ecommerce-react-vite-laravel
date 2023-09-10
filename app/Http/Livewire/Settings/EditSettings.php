<?php

namespace App\Http\Livewire\Settings;

use App\Services\SettingService;
use App\Traits\TraitUploadImage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditSettings extends Component
{
	use TraitUploadImage, WithFileUploads;

	public $label = 'Ajuste';

	public $labelPlural = 'Ajustes';

	public $logo;

	public $settings;

	protected $rules = [
		// 'logo' => 'required|string|max:255',
		'settings.company.name' => 'required|string|min:3|max:255',
		'settings.company.address' => 'required|string|max:255',
		'settings.company.email' => 'required|email|max:255',
		'settings.company.phone' => 'required|string|max:255',
		'settings.company.entry' => 'required|string|max:1000',
		'logo' => 'nullable|sometimes|image|max:2024|mimes:jpeg,jpg,png,svg',

		'settings.rates.tax' => 'required|numeric|min:0',
		'settings.rates.shipping' => 'required|numeric|min:0',
		'settings.rates.freeShipping' => 'nullable|numeric|min:0',
	];

	protected $validationAttributes = [
		'settings.company.name' => 'Nombre',
		'settings.company.address' => 'Direccion',
		'settings.company.email' => 'Email',
		'settings.company.phone' => 'Telefono',
		'settings.company.logo' => 'Logo',
		'settings.company.entry' => 'Eslogan',
		'settings.rates.tax' => 'Impuestos',
		'settings.rates.shipping' => 'Envio',
	];

	public function mount()
	{
		$this->settings = SettingService::data();
	}

	public function update()
	{

		$this->validate();

		if ($this->logo) {
			if ($this->settings['company']['logo']) {
				Storage::delete($this->settings['company']['logo']);
			}
			$this->settings['company']['logo'] = $this->upload_image('logo', 'settings', $this->logo);
		}

		SettingService::put($this->settings);

		$this->reset('logo');

		$this->dispatchBrowserEvent('notification', [
			'title' => "$this->labelPlural Guardados",
			// 'subtitle' => "",
		]);
		Cache::flush();
	}

	public function updateLogo(): void
	{
		$this->validate([
			'logo' => 'image|max:1024|mimes:jpeg,jpg,png',
		]);
	}

	public function render()
	{
		return view('livewire.settings.edit-settings');
	}
}
