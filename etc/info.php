<?php

use Obelaw\Schema\ModuleInfo;

return new class
{
    public function setInfo(ModuleInfo $module)
    {
        $module->info(
            name: 'Catalog',
            icon: 'barcode',
            href: 'obelaw.catalog.home',
            helper: true
        );
    }
};
