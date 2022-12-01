<?php

namespace Web\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use Delgont\Cms\Models\Menu\Menu;


class MenuService
{
    private $menu;

    public function __construct()
    {
        $this->menu = new Menu();
    }

    public function get($menu_key, $maxLevel = 0)
    {
        return $this->menu->where('key',$menu_key)->withMenuItems($maxLevel)->first();
    }

    public function getSimpleMenu($menu_key)
    {
        return $this->menu->where('key', $menu_key)->withSimpleMenuItems()->first();
    }
   
}