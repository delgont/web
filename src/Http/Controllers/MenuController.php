<?php

namespace Web\Http\Controllers;
use Web\Http\Controllers\BaseController;

use Web\Services\MenuService;




class MenuController extends BaseController
{
    public function index($key)
    {
        $menu = app(MenuService::class)->get($key);
        return response()->json($menu, 200);
    }
}
