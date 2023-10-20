<?php

namespace Obelaw\Catalog;

use Livewire\Livewire;
use Obelaw\Catalog\Livewire\Categories\CatagoryCreateComponent;
use Obelaw\Catalog\Livewire\Products\ProductCreateComponent;
use Obelaw\Catalog\Livewire\Products\ProductsIndexComponent;
use Obelaw\Catalog\Livewire\Products\ProductUpdateComponent;
use Obelaw\Framework\Base\ServiceProviderBase;

class ObelawCatalogServiceProvider extends ServiceProviderBase
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'obelaw-catalog');

        Livewire::component('obelaw-catalog-catagory-index', CatagoryCreateComponent::class);

        Livewire::component('obelaw-catalog-product-index', ProductsIndexComponent::class);
        Livewire::component('obelaw-catalog-product-create', ProductCreateComponent::class);
        Livewire::component('obelaw-catalog-product-update', ProductUpdateComponent::class);
    }
}
