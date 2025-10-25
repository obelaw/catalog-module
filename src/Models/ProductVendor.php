<?php

namespace Obelaw\Catalog\Models; // Assuming moved to this namespace

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Twist\Base\BaseModel;

class ProductVendor extends BaseModel
{
    protected $table = 'catalog_product_vendors';

    protected $fillable = [
        'product_id',
        'vendor_id',
        'purchase_price',
    ];


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
