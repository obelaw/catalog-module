<?php

use Obelaw\Framework\Builder\Build\Navbar\Links;

return new class
{
    public function navbar(Links $links)
    {
        $links->link(
            icon: 'dashboard',
            label: 'Dashboard',
            href: 'obelaw.purchasing.home',
        );

        $links->link(
            icon: 'tags',
            label: 'Categories',
            href: 'obelaw.catalog.categories.list',
        );

        $links->link(
            icon: 'brand-producthunt',
            label: 'Products',
            href: 'obelaw.catalog.products.list',
        );
    }
};
