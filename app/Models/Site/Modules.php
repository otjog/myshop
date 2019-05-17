<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class Modules extends Model
{
    public function getModules($schema){
        $module = $schema['current']['content']['content_bottom'][2];

        if(isset($module['resource']) && $module['resource'] !== null){
            $moduleKeys = explode('.', $module['resource']);

            $x = 'App\Models\Site\Page';

            $RFC = new ReflectionClass($x);

            $model = $RFC->newInstance();

            $data = $model->getPageIfActive($moduleKeys[2]);

            //dd($data);
        }
    }
}
