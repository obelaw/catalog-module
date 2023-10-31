<?php

use Obelaw\Catalog\Models\Variant;
use Obelaw\Framework\Builder\Build\Grid\{
    CTA,
    Table,
    Bottom
};

return new class
{
    public function model()
    {
        return Variant::class;
    }

    public function createBottom(Bottom $bottom)
    {
        $bottom->setBottom('Create New Variant', 'obelaw.catalog.variants.create');
    }

    public function table(Table $table)
    {
        $table->setColumn('#', 'id')
            ->setColumn('Reference', 'serial')
            ->setColumn('Name', 'name')
            ->setColumn('Cost', 'cost');
    }

    public function CTA(CTA $CTA)
    {
        $CTA->setCall('Update', [
            'type' => 'route',
            'color' => 'primary',
            'route' => 'obelaw.catalog.variants.update',
        ]);
    }
};
