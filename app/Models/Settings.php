<?php

namespace App\Models;

use App\Models\Shop\Price\Currency;
use App\Models\Shop\Price\Price;

class Settings {

    private static $instance = null;

    private $currency;

    private $price;

    public $data;

    public static function getInstance(){
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct(){

        $this->currency = new Currency();

        $this->price = new Price();

        $this->data = config('general');
        $this->data['components']['shop']['currency'] =
            $this->currency
                ->select('id', 'char_code', 'symbol')
                ->where('main', '1')
                ->first();
        $this->data['components']['shop']['price'] =
            $this->price
                ->select('id', 'name')
                ->where('name', 'retail')
                ->first();

    }

    private function __clone(){}

    public function addParameter($name, $value){
        $this->data[$name] = $value;
    }

    public function getParameters(){
       return $this->data;
    }

    public function getParameter($path){

        $data = $this->getParameters();

        $pathArray = explode('.', $path);

        $temporary = [];

        foreach( $pathArray as $key => $level ){

            if($key === 0)
                $temporary = $data;

            if($key+1 === count($pathArray) )
                return $this->getLevel($temporary, $level);
            else
                $temporary = $this->getLevel($temporary, $level);
        }

    }

    private function getLevel($array, $level){

        return $array[ $level ];

    }

}