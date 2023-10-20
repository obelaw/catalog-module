<?php

use Obelaw\Framework\Builder\Build\Grid\{
    CTA,
    Table,
    Bottom
};
use Obelaw\Catalog\Models\Product;

return new class
{
    public function model()
    {
        return Product::class;
    }

    public function createBottom(Bottom $bottom)
    {
        $bottom->setBottom('Create new product', 'obelaw.catalog.products.create');
    }

    public function table(Table $table)
    {
        $table->setColumn('Name', 'name')
            ->setColumn('SKU', 'sku')
            ->setColumn('Type', 'type')
            ->setColumn('Catagory', 'catagory_name');
    }

    public function CTA(CTA $CTA)
    {
        $CTA->setCall('Edit', [
            'type' => 'route',
            'route' => 'obelaw.catalog.products.update',
        ]);
    }
};
