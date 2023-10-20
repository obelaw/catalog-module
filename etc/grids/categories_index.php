<?php

use Obelaw\Framework\Builder\Build\Grid\{
    CTA,
    Table,
    Bottom
};
use Obelaw\Catalog\Models\Catagory;

return new class
{
    public function model()
    {
        return Catagory::class;
    }

    public function createBottom(Bottom $bottom)
    {
        $bottom->setBottom('obelaw-warehouse::grids.name', 'obelaw.catalog.categories.create');
        // $bottom->setBottom('Create new catagory', 'obelaw.warehouse.products.categories.create');
    }

    public function table(Table $table)
    {
        $table->setColumn('#', 'id')
            ->setColumn('obelaw-warehouse::grids.name', 'name');
    }

    public function CTA(CTA $CTA)
    {
        $CTA->setCall('Edit', [
            'type' => 'route',
            'route' => 'obelaw.catalog.categories.update',
        ]);
    }
};
