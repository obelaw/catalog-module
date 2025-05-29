<?php

namespace Obelaw\Catalog\Lib\Services;

use Obelaw\Catalog\Enums\StockType;
use Obelaw\Catalog\Models\Product;


class ProductService
{
    public function getCountConsumableType()
    {
        return Product::where('product_type', StockType::CONSUMABLE())->count();
    }

    public function getCountServiceType()
    {
        return Product::where('product_type', StockType::SERVICE())->count();
    }

    public function getCountStorableType()
    {
        return Product::where('product_type', StockType::STORABLE())->count();
    }
}
