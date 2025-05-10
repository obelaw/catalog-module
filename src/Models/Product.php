<?php

namespace Obelaw\Catalog\Models;

use App\Models\ProductGallery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Obelaw\Accounting\Facades\PriceLists;
use Obelaw\Audit\Traits\HasSerialize;
use Obelaw\Catalog\Enums\ProductScope;
use Obelaw\Catalog\Enums\ProductType;
use Obelaw\Catalog\Enums\StockType;
use Obelaw\Catalog\Models\AttributeValue; // Corrected namespace
use Obelaw\Catalog\Models\Catagory;
use Obelaw\Catalog\Models\ProductAttribute; // Pivot model
use Obelaw\Catalog\Models\ProductRelated;
use Obelaw\Twist\Base\BaseModel;

class Product extends BaseModel
{
    use HasFactory;
    use HasSerialize;

    protected static $serialSection = 'catal';
    protected $table = 'catalog_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parent_id',
        'category_id',
        'product_type',
        'product_scope',
        'stock_type',
        'name',
        'inventory_sku',
        'inventory_quantity',
        'inventory_safety_stock',
        'thumbnail',
        'gallery',
        'description',
        'can_sold',
        'can_purchased',
        'price_sales',
        'price_purchase',
        'special_price',
        'special_price_from',
        'special_price_to',
        'stock_quantity',
    ];

    protected $casts = [
        'product_type' => ProductType::class,
        'product_scope' => ProductScope::class,
        'stock_type' => StockType::class,
        'gallery' => 'array'
    ];

    public static function serialPrefix($record)
    {
        return match ($record->product_scope->value) {
            ProductScope::RAW_MATERIAL() => 'RAW',
            ProductScope::SEMI_FINISHED() => 'SEMI',
            ProductScope::FINISHED() => 'FINI',
        };
    }

    public function getCatagoryNameAttribute()
    {
        return $this->catagory->name ?? '--';
    }

    public function getPriceSalesAttribute($value): float
    {
        return $value ?? 0;
    }

    public function getFinalPriceSalesAttribute(): float
    {
        return PriceLists::getCurrentPriceBySKU($this->sku) ?? $this->price_sales ?? 0;
    }

    public function getPricePurchaseAttribute($value): float
    {
        return $value ?? 0;
    }

    public function scopeCanSold($query)
    {
        return $query->where('can_sold', true);
    }

    public function scopeCanPurchased($query)
    {
        return $query->where('can_purchased', true);
    }

    public function scopeInPos($query)
    {
        return $query->where('in_pos', true);
    }

    public function catagory()
    {
        return $this->hasOne(Catagory::class, 'id', 'category_id');
    }

    public function related()
    {
        return $this->hasMany(ProductRelated::class, 'product_id', 'id');
    }


    ///

    public function options()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id', 'id');
    }
}
