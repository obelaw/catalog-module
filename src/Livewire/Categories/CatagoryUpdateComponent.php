<?php

namespace Obelaw\Catalog\Livewire\Categories;

use Obelaw\Catalog\Models\Catagory;
use Obelaw\Framework\Base\FromBase;

class CatagoryUpdateComponent extends FromBase
{
    public $formId = 'obelaw_catalog_categories_form';

    public $catagory;

    public function mount(Catagory $catagory)
    {
        $this->parent_id = $catagory->parent_id;
        $this->name = $catagory->name;
        $this->catagory = $catagory;
    }

    public function submit()
    {
        $validateData = $this->validate();
        $this->catagory->update($validateData);
        $this->pushAlert('success', 'Updated!');
    }
}
