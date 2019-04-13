<?php

namespace App\Http\ViewComposers;

use App\Models\Site\Menu;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class ModelMenuComposer
{

    protected $menus;

    public function __construct(Menu $menu){

        $this->menus = Cache::remember('site:menus:activeMenus', '60', function() use ($menu){
            return $menu->getActiveMenus();
        });

    }

    public function compose(View $view){
        $view->with('menus', $this->menus);
    }
}