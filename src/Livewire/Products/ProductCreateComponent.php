<?php

namespace Obelaw\Catalog\Livewire\Products;

use Obelaw\Catalog\Models\Product;
use Obelaw\Framework\Base\FromBase;

class ProductCreateComponent extends FromBase
{
    public $formId = 'obelaw_catalog_products_form';

    public function submit()
    {
        $validateData = $this->validate();

        $validateData['can_sold'] = $validateData['can']['sold'] ?? null;
        $validateData['can_purchased'] = $validateData['can']['purchased'] ?? null;

        unset($validateData['can']);

        Product::create($validateData);
    }
}
