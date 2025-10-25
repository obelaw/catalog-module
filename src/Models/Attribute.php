<?php

namespace Obelaw\Catalog\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Twist\Base\BaseModel;

class Attribute extends BaseModel
{
    protected $table = 'catalog_attributes';

    protected $fillable = [
        'name',
    ];

    /**
     * Get the options (values) for this attribute.
     */
    public function values(): HasMany
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id');
    }

    // public function products(): BelongsToMany
    // {
    //     return $this->belongsToMany(Product::class, 'catalog_product_attributes', 'attribute_id', 'product_id')
    //         ->withPivot('attribute_value_id', 'is_configurable')
    //         ->withTimestamps();
    // }
}
