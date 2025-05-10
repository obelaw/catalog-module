<?php

namespace Obelaw\Catalog\Models; // Assuming moved to this namespace

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Obelaw\Catalog\Enums\OptionsPriceType;
use Obelaw\Twist\Base\BaseModel;

class ProductAttribute extends BaseModel
{
    protected $table = 'catalog_product_attributes';

    protected $fillable = [
        'product_id',
        'attribute_id',
        'attribute_value_id',
        'sku',
        'type_price',
        'special_price',
    ];

    protected $casts = [
        'type_price' => OptionsPriceType::class,
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

    public function attributeValue(): BelongsTo
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
    }
}
