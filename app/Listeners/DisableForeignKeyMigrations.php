<?php

namespace App\Listeners;

use Illuminate\Database\Events\MigrationsStarted;
use Illuminate\Support\Facades\Schema;

class DisableForeignKeyMigrations
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(MigrationsStarted $event)
    {
        Schema::disableForeignKeyConstraints();
    }
}
