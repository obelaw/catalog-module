<?php

use Obelaw\Framework\Builder\Build\Grid\{
    CTA,
    Table,
    Bottom
};
use Obelaw\Catalog\Models\Product;
use Obelaw\Framework\Builder\Build\Common\RouteAction;

return new class
{
    public function model()
    {
        return Product::class;
    }

    public function createBottom(Bottom $bottom)
    {
        $bottom->setBottom(
            label: 'Create New Product',
            route: 'obelaw.catalog.products.create',
            permission: 'catalog_products_create',
        );
    }

    public function table(Table $table)
    {
        $table->setColumn('#', 'id')
            ->setColumn('Reference', 'serial')
            ->setColumn('Name', 'name')
            ->setColumn('SKU', 'sku')
            ->setColumn('Type', 'product_type')
            ->setColumn('Catagory', 'catagory_name');
    }

    public function CTA(CTA $CTA)
    {
        $CTA->setCall('Update', new RouteAction(
            href: 'obelaw.catalog.products.update',
            permission: 'catalog_products_update',
        ));
    }
};
