<?php

namespace Obelaw\Catalog\Livewire\Categories;

use Obelaw\Catalog\Models\Catagory;
use Obelaw\Framework\ACL\Attributes\PermissionAccess;
use Obelaw\Framework\Base\FromBase;

#[PermissionAccess('catalog_categories_create')]
class CatagoryCreateComponent extends FromBase
{
    public $formId = 'obelaw_catalog_categories_form';

    public function submit()
    {
        $validateData = $this->validate();

        Catagory::create($validateData);
    }
}
