<?php

namespace Obelaw\Catalog\Livewire\Variants;

use Obelaw\Catalog\Models\Variant;
use Obelaw\Framework\Base\FromBase;

class CreateVariantComponent extends FromBase
{
    public $formId = 'obelaw_catalog_variant_form';

    protected $pretitle = 'Variants';
    protected $title = 'Create New Variant';

    public function submit()
    {
        $validateData = $this->validate();

        Variant::create($validateData);

        return $this->pushAlert('success', 'The variant has been created');
    }
}
