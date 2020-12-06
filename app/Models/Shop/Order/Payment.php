<?php

namespace App\Models\Shop\Order;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model{

    public function shopOrders()
    {
        return $this->hasMany('App\Models\Shop\Order\Order');
    }

    protected $table = 'shop_payments';

    public function images()
    {
        return $this->morphToMany('App\Models\Site\Image', 'imageable');
    }

    public function getActiveMethods(){
        return self::select(
            'id',
            'alias',
            'name',
            'description',
            'tax',
            'tax_type'
        )
            ->with('images')
            ->where('active', 1)
            ->get();
    }

    public function getMethodById($id){
        return self::select(
            'id',
            'alias',
            'name',
            'description',
            'tax',
            'tax_type'
        )
            ->with('images')
            ->where('active', 1)
            ->where('id', $id)
            ->get();
    }

}
