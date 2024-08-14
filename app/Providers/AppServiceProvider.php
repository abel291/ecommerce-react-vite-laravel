<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        Number::useLocale('de');

        // Event::listen(
        //     DisableForeignKeyMigrations::class,
        // );

        // Model::unguard();

        // EditAction::configureUsing(function (EditAction $action): void {
        //     $action->icon(false);
        // }, isImportant: true);

        // DeleteAction::configureUsing(function (DeleteAction $action): void {
        //     $action->icon(false);
        // }, isImportant: true);
        // ViewAction::configureUsing(function (ViewAction $action,): void {
        //     $action->icon(false)->label('Ver');
        // }, isImportant: true);

        // Table::configureUsing(function (Table $table): void {
        //     $table->defaultPaginationPageOption(10)->defaultSort('id', 'desc');
        //     // $table->filtersLayout(FiltersLayout::AboveContent);
        //     $table->searchDebounce('400ms');
        //     $table->filtersTriggerAction(
        //         fn (Action $action) => $action
        //             ->button()
        //             ->label('Filtros'),
        //     );;
        // });

        // Infolist::$defaultDateTimeDisplayFormat = 'M j, Y h:i a';

        // Table::$defaultDateTimeDisplayFormat = 'M j, Y h:i a';
        // DateTimePicker::$defaultDateTimeDisplayFormat = 'M j, Y h:i a';

        // Table::$defaultNumberLocale = 'de';

        // Select::configureUsing(function (Select $component): void {
        //     $component->native(false);
        // });

        // SelectFilter::configureUsing(function (SelectFilter $component): void {
        //     $component->native(false);
        // });
    }
}
