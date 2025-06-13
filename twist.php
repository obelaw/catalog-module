<?php

use Obelaw\Catalog\CatalogAddon;

\Obelaw\Twist\Addons\AddonRegistrar::register(
    'obelaw.catalog',
    CatalogAddon::class,
    config('obelaw.catalog.panels')
);
