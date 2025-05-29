<?php

namespace Obelaw\Catalog;

use Illuminate\Support\ServiceProvider;
use Obelaw\Contacts\ContactType;
use Obelaw\Twist\Addons\AddonsPool;

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
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        AddonsPool::loadTwist(__DIR__ . '/../twist.php');
    }
}
