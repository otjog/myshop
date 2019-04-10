<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use App\Models\Shop\Category\Category;
use App\Models\Site\Page;

class Menu extends Model
{
    public function models(){
        return $this->belongsToMany('App\Models\Site\MenuModel', 'menu_has_model')->withTimestamps();
    }

    public function getActiveMenus(){

        $menus = self::select(
            'menus.id',
            'menus.alias',
            'menus.name'
        )
            ->with(['models' => function ($query) {
                $query->select('name', 'menu_has_model.ids', 'menu_has_model.header', 'menu_has_model.view')
                ->orderBy('sort', 'asc');
            }])
            ->where('active', 1)
            ->get();

        return $this->addRelationToEachMenu($menus);

    }

    private function addRelationToEachMenu($menus){

        $newMenus = collect();

        foreach ($menus as $menu) {

            foreach ($menu->models as $model) {
                switch ($model->name) {
                    case 'categories' :
                        $category = new Category();

                        $idsArray = explode('|', $model->ids);

                        if($idsArray[0] === '0'){
                            $model->relations['categories'] = $category->getCategoriesTree();
                        }else{
                            $model->relations['categories'] = $category->getActiveCategoriesById($idsArray);
                        }
                        break;
                    case 'pages' :
                        $page = new Page();

                        $idsArray = explode('|', $model->ids);

                        if($idsArray[0] === '0'){
                            $model->relations['pages'] = $page->getActivePages();
                        }else{
                            $model->relations['pages'] = $page->getActivePagesById($idsArray);
                        }
                        break;
                }
                $newMenus->put($menu->alias, $menu);
            }

        }
        unset($menus);
        return $newMenus;
    }
}