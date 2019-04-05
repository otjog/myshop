<?php

namespace App\Http\ViewComposers;

use App\Models\Site\Menu;
use Illuminate\View\View;

class ModelsMenuComposer{

    protected $menu;

    public function __construct(Menu $menu){
        $this->menu = $menu;
    }

    public function compose(View $view){
        $view->with('menus', $this->menu->getActiveMenus());
    }
}