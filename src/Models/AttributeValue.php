<?php

namespace Obelaw\Catalog\Models; // Assuming moved to this namespace

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Obelaw\Catalog\Models\Attribute;
use Obelaw\Catalog\Models\Product;
use Obelaw\Twist\Base\BaseModel; // Assuming it should extend BaseModel

class AttributeValue extends BaseModel // Extend BaseModel for prefixing
{
    protected $table = 'catalog_attribute_values';

    protected $fillable = [
        'attribute_id',
        'value',
        'code',
        'sort_order',
        'swatch_value',
    ];

    /**
     * Get the attribute that this value belongs to.
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'catalog_product_attributes', 'attribute_value_id', 'product_id');
    }
}
