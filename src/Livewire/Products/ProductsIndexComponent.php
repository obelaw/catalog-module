<?php

namespace Obelaw\Catalog\Livewire\Products;

use Obelaw\Catalog\Models\Product;
use Obelaw\Framework\ACL\Attributes\PermissionAccess;
use Obelaw\Framework\Base\GridBase;

#[PermissionAccess('catalog_products_index')]
class ProductsIndexComponent extends GridBase
{
    public $gridId = 'obelaw_catalog_products_index';

    public function submit()
    {
        $validateData = $this->validate();

        Product::create($validateData);
    }
}
