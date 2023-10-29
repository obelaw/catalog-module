<?php

namespace Obelaw\Catalog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Obelaw\Framework\Base\ModelBase;

class Product extends ModelBase
{
    use HasFactory;

    protected $table = 'catalog_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'catagory_id',
        'name',
        'sku',
        'type',
        'can_sold',
        'can_purchased',
        'in_pos',
    ];

    public function getCatagoryNameAttribute()
    {
        return $this->catagory->name ?? '--';
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
        return $this->hasOne(Catagory::class, 'id', 'catagory_id');
    }
}
