<?php

namespace Obelaw\Catalog\Filament\Clusters;

use Filament\Clusters\Cluster;
use Obelaw\Twist\Facades\Twist;

class CatalogCluster extends Cluster
{
    protected static ?int $navigationSort = 1000;
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function getNavigationGroup(): ?string
    {
        if (Twist::hasAddon('obelaw.salespulse'))
            return 'Sales Pulse';

        if (Twist::hasAddon('obelaw.erp.sales'))
            return 'ERP';

        return null;
    }
}
