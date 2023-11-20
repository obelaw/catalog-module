<?php

namespace Obelaw\Catalog\Livewire\Categories;

use Obelaw\Catalog\Models\Product;
use Obelaw\Framework\ACL\Attributes\PermissionAccess;
use Obelaw\Framework\Base\GridBase;

#[PermissionAccess('catalog_categories_index')]
class CategoriesIndexComponent extends GridBase
{
    public $gridId = 'obelaw_catalog_categories_index';

    public function submit()
    {
        $validateData = $this->validate();

        Product::create($validateData);
    }
}
