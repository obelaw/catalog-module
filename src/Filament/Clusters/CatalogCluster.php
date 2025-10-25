<?php

namespace Obelaw\Catalog\Filament\Clusters;

use Filament\Clusters\Cluster;
use Twist\Facades\Twist;

class CatalogCluster extends Cluster
{
    protected static ?int $navigationSort = 1000;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-squares-2x2';

    public static function getNavigationGroup(): ?string
    {
        if (Twist::hasAddon('obelaw.oms'))
            return 'OMS';

        if (Twist::hasAddon('obelaw.erp.sales'))
            return 'ERP';

        return null;
    }
}
