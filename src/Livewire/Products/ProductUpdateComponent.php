<?php

namespace Obelaw\Catalog\Livewire\Products;

use Obelaw\Catalog\Models\Product;
use Obelaw\Framework\Base\FromBase;
use Obelaw\Framework\Base\Traits\PushAlert;

class ProductUpdateComponent extends FromBase
{
    use PushAlert;

    public $formId = 'obelaw_catalog_products_form';

    public $product;

    public function mount(Product $product)
    {
        $this->catagory_id = $product->catagory_id;
        $this->name = $product->name;
        $this->sku = $product->sku;
        $this->type = $product->type;
        $this->product = $product;
    }

    public function submit()
    {
        $validateData = $this->validate();
        $this->product->update($validateData);
        $this->pushAlert('success', 'Updated!');
    }
}
