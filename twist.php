<?php

use Twist\Addons\AddonRegistrar;
use Obelaw\Catalog\CatalogAddon;

AddonRegistrar::register(
    'obelaw.catalog',
    CatalogAddon::class,
    config('obelaw.catalog.panels')
);
