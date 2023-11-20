<?php

namespace Obelaw\Catalog\Livewire\Variants;

use Obelaw\Catalog\Models\Variant;
use Obelaw\Framework\ACL\Attributes\PermissionAccess;
use Obelaw\Framework\Base\GridBase;
use Obelaw\Framework\Base\Traits\PushAlert;

#[PermissionAccess('catalog_variants_index')]
class IndexVariantsComponent extends GridBase
{
    use PushAlert;

    public $gridId = 'obelaw_catalog_variants_index';

    protected $pretitle = 'Variants';
    protected $title = 'Variants Listing';

    public function removeRow(Variant $variant)
    {
        $variant->delete();
        return $this->pushAlert('success', 'The variant has been deleted');
    }
}
