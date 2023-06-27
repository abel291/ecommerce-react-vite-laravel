<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class DepartmentController extends Controller
{
	public function department($department)
	{
		$department = Category::active()->where('slug', $department)->whereNull('category_id')->firstOrFail();

		$offert = $department->products()->activeInStock()
			->whereNotNull('offer')
			->inRandomOrder()->limit(20)->get();

		$best_sellers = $department->department_products()
			->activeInStock()

			->withCount(['orders' => function ($query) {
				$query->whereHas('payment', function (Builder $query) {
					$query->where('status', PaymentStatus::SUCCESSFUL);
				});
			}])

			->whereHas('orders.payment', function ($query) {
				$query->where('status', PaymentStatus::SUCCESSFUL);
			})
			->orderBy('orders_count', 'desc')
			->inRandomOrder()->limit(20)
			->get();

		$brands = Brand::active()
			->withCount(['products' => function ($query) use ($department) {
				$query->whereHas('department', function (Builder $query) use ($department) {
					$query->where('id', $department->id);
				});
			}])
			->whereHas('products.department', function ($query) use ($department) {
				$query->where('id', $department->id);
			})
			->orderBy('products_count', 'desc')
			->inRandomOrder()->limit(20)
			->get();

		$blog=Blog::
	}
}
