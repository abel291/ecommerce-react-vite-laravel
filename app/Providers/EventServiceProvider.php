<?php

namespace App\Providers;

use App\Listeners\DisableForeignKeyMigrations;
use App\Models\Image;
use App\Models\OrderProduct;
use App\Observers\ImageObserver;
use App\Observers\OrderProductObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Database\Events\MigrationsStarted;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
	/**
	 * The event to listener mappings for the application.
	 *
	 * @var array<class-string, array<int, class-string>>
	 */
	protected $listen = [
		Registered::class => [
			SendEmailVerificationNotification::class,
		],
		MigrationsStarted::class => [
			DisableForeignKeyMigrations::class,
		],
	];

	/**
	 * Register any events for your application.
	 */
	public function boot(): void
	{
		OrderProduct::observe(OrderProductObserver::class);
		//cada que se crea una orden se le resta al stock del producto

		Image::observe(ImageObserver::class);
	}

	/**
	 * Determine if events and listeners should be automatically discovered.
	 */
	public function shouldDiscoverEvents(): bool
	{
		return false;
	}
}
