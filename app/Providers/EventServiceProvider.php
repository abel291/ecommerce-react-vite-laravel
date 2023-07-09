<?php

namespace App\Providers;

use App\Listeners\DisableForeignKeyMigrations;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\OrderProduct;
use App\Models\Payment;
use App\Observers\BrandObserver;
use App\Observers\CategoryObserver;
use App\Observers\ImageObserver;
use App\Observers\OrderProductObserver;
use App\Observers\PaymentObserver;
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

        Payment::observe(PaymentObserver::class);
        //cada que se crea  un pago se le resta al stock los productos de la orden

        Image::observe(ImageObserver::class);
        Category::observe(CategoryObserver::class);
        Brand::observe(BrandObserver::class);
        OrderProduct::observe(OrderProductObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
