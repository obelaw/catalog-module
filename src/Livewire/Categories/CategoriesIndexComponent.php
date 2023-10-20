<?php

namespace Obelaw\Catalog\Livewire\Categories;

use Obelaw\Catalog\Models\Product;
use Obelaw\Framework\Base\GridBase;

class CategoriesIndexComponent extends GridBase
{
    public $gridId = 'obelaw_catalog_categories_index';

    public function submit()
    {
        $validateData = $this->validate();

        Product::create($validateData);
    }
}
