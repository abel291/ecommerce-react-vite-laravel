<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use Laravel\Telescope\Telescope;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		//Telescope::ignoreMigrations();
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		Cashier::ignoreMigrations();
		Cashier::useCustomerModel(User::class);
		JsonResource::withoutWrapping();

		Blade::directive('money', function ($money) {
			return "<?php echo '$ ' . number_format($money, 2); ?>";
		});
	}
}
