<?php

use Obelaw\Framework\Builder\Build\Grid\{
    CTA,
    Table,
    Bottom
};
use Obelaw\Catalog\Models\Catagory;
use Obelaw\Framework\Builder\Build\Common\RouteAction;

return new class
{
    public function model()
    {
        return Catagory::class;
    }

    public function createBottom(Bottom $bottom)
    {
        $bottom->setBottom(
            label: 'Create new Category',
            route: 'obelaw.catalog.categories.create',
            permission: 'catalog_categories_create',
        );
    }

    public function table(Table $table)
    {
        $table->setColumn('#', 'id')
            ->setColumn('obelaw-warehouse::grids.name', 'name');
    }

    public function CTA(CTA $CTA)
    {
        $CTA->setCall('Update', new RouteAction(
            href: 'obelaw.catalog.categories.update',
            permission: 'catalog_categories_update',
        ));
    }
};
