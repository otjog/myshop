<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class Marketplace extends Model
{

    protected $table = 'shop_marketplaces';

    public function products(){
        return $this->belongsToMany('App\Models\Shop\Product\Product', 'shop_marketplace_has_product')->withTimestamps();
    }

    public function getMarketplacesWithProducts ($alias)
    {
        return self::select(
            'id',
            'alias',
            'name'
        )
            ->where('active', '1')
            ->with('products')
            ->get();
    }
}
