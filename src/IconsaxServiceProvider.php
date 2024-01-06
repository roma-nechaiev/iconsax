<?php

namespace SaxUi\Iconsax;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use SaxUi\Iconsax\AddCommand;

class IconsaxServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                AddCommand::class,
            ]);
        }
    }

    public function provides()
    {
        return [
            AddCommand::class,
        ];
    }
}
