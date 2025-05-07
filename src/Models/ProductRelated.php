<?php

namespace Obelaw\Catalog\Models;

use Obelaw\Twist\Base\BaseModel;

class ProductRelated extends BaseModel
{
    protected $table = 'catalog_product_related';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'related_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id', 'product_id');
    }

    public function related()
    {
        return $this->belongsTo(Product::class, 'related_id', 'id');
    }
}
