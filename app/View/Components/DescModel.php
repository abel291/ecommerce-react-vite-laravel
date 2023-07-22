<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DescModel extends Component
{
	public $img;

	public $descList = [];

	public function __construct(
		public string $modelName,
		public int $modelId,
		//da error al poner $model como nombre de var

	) {
		$modelData = $this->modelName::find($this->modelId);
		switch (class_basename($modelData)) {
			case 'Product':
				$this->img = $modelData->img;
				$this->descList = [
					'Categoryia' => $modelData->category->name,
					'Producto' => $modelData->name,
				];
				break;

			default:
				// code...
				break;
		}
	}

	/**
	 * Get the view / contents that represent the component.
	 */
	public function render(): View|Closure|string
	{
		return view('components.desc-model');
	}
}
