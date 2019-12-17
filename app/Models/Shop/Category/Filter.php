<?php

namespace App\Models\Shop\Category;

use Illuminate\Database\Eloquent\Model;
use App\Models\Shop\Product\Product;
use App\Facades\GlobalData;

class Filter extends Model{

    protected $moduleMethods = [
        'show' => 'getActiveFiltersWithParameters',
    ];

    public function getModuleMethods($moduleMethod)
    {
        return $this->moduleMethods[$moduleMethod];
    }

    public function getActiveFiltersWithParameters(){

        $products = new Product();

        $filters =  self::select(
            'filters.id',
            'filters.alias',
            'filters.name',
            'filters.type',
            'filters.expanded'
        )
            ->where('filters.active', 1)
            ->orderBy('filters.sort')
            ->get();

        return $this->getParametersForFilters($products, $filters);

    }

    public function getParametersForFilters(Product $productModel, $filters )
    {
        $prefix = GlobalData::getParameter('components.shop.filter_prefix');

        $temporary = [];

        $old_values = request()->all();

        $routeParameters = request()->route()->parameters;

        $products = $productModel->getProductsFromRoute($routeParameters, [], false);

        foreach ($filters as $key => $filter) {
            foreach ($routeParameters as $routeName => $id) {
                if ($routeName !== $filter['alias']) {

                    if($filter['expanded']){
                        $filter['expanded'] = 'true';
                    }else{
                        $filter['expanded'] = 'false';
                    }

                    switch($filter['alias']){

                        case 'manufacturer' :

                            /* если решим показывать в фильтре товары без производителя
                            $manufacturers = $productsInCategory->map(function ($value, $key){
                                $manufacturer = $value->relations['manufacturer'];

                                 if($manufacturer['id'] !== null && $manufacturer['name'] !== null){
                                     return [ 'id' => $manufacturer['id'], 'name' => $manufacturer['name'] ];
                                 }
                                 return [ 'id' => 0, 'name' => 'Не задан' ];

                            });
        */

                            $manufacturers  = $products->pluck('manufacturer');

                            $distinctManfs  = $manufacturers->pluck('name', 'id');

                            $filter['values']   = $distinctManfs->filter(function ($value, $key) {
                                return $key !== '' && $value !== null;
                            });

                            $filter['old_values']   = $this->addOldValues($old_values, $filter['alias']);

                            break;

                        case 'price'        :
                            $prices = $products->pluck('price');

                            $values = [
                                $prices->min('value'),
                                $prices->max('value'),
                            ];

                            if($values[0] !== null || $values[1] !== null ){
                                $filter['values'] = $values;
                            }else{
                                $filter['values'] = [];
                            }

                            $filter['old_values']   = $this->addOldValues($old_values, $filter['alias']);

                            break;

                        case 'phrase'       :

                            $filter['values']       = [];

                            $filter['old_values']   = $this->addOldValues($old_values, $filter['alias']);

                            break;

                        case 'category'     :

                            $categories  = $products->pluck('category');

                            $distinctCat  = $categories->pluck('name', 'id');

                            $filter['values']   = $distinctCat->filter(function ($value, $key) {
                                return $key !== '' && $value !== null;
                            });

                            $filter['old_values']   = $this->addOldValues($old_values, $filter['alias']);

                            break;

                        default             :
                            if($filter['filter_type'] === 'slider-range'){

                                //todo должно отдавать только минимальное и максимальное значение, как в price
                                //todo проверка значений на null
                                $filter['values']       = [$filter['value']];

                                $filter['old_values']   = $this->addOldValues($old_values, $filter['alias']);

                                break;

                            }else{

                                $parameters = $products->pluck('parameters');

                                $values = [];

                                foreach($parameters as $productParameters){

                                    foreach($productParameters as $parameter){

                                        if( $parameter->alias === $filter['alias']){

                                            if( !isset($values[ $parameter->pivot->value ])){
                                                $values[ $parameter->pivot->value ] = $parameter->pivot->value;
                                            }

                                        }

                                    }
                                }

                                $filter['alias']        = $prefix . $filter['alias'];

                                asort($values);
                                $filter['values']       = array_flip($values);

                                $filter['old_values']   = $this->addOldValues($old_values, $filter['alias']);

                                break;

                            }
                    }

                    if( count( $filter['values'] ) > 0){
                        $temporary[] = $filter;
                    }

                }
            }
        }

        return ['filters' => $temporary];
    }

    private function addOldValues($old_values, $filter_alias){
        if( isset( $old_values[ $filter_alias ] ) ){
            return $old_values[ $filter_alias ];
        }
        return [];
    }
}
