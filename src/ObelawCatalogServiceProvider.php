<?php

namespace Obelaw\Catalog;

use Illuminate\Support\ServiceProvider;
use Obelaw\Contacts\ContactType;
use Twist\Addons\AddonsPool;

class ObelawCatalogServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        ContactType::add('VENDOR', 2);

        $this->mergeConfigFrom(
            __DIR__ . '/../config/catalog.php',
            'obelaw.catalog'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        AddonsPool::loadTwist(__DIR__ . '/../twist.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/catalog.php' => config_path('obelaw/catalog.php'),
            ]);
        }
    }
}
