<?php

namespace Obelaw\Catalog\Services;

use Obelaw\Catalog\Models\Product;
use Twist\Base\BaseService;

class ProductService extends BaseService
{
    public Product $product;

    public function setProduct(Product $product)
    {
        $this->product = $product;

        return $this;
    }

    public function getProductName()
    {
        return $this->product->name;
    }

    public function getProductSKU()
    {
        return $this->product->inventory_sku;
    }

    public function canSold()
    {
        return $this->product->sales_can_sold;
    }

    public function salePrice()
    {
        return $this->product->sales_sale_price;
    }

    public function specialSalePrice()
    {
        return $this->product->sales_special_price;
    }

    public function finalSalePrice()
    {
        if ($this->specialSalePrice())
            return $this->specialSalePrice();

        return $this->salePrice();
    }
}
