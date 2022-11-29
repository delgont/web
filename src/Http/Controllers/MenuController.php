<?php

namespace Web\Http\Controllers;
use Web\Http\Controllers\BaseController;

use Web\Services\MenuService;




class MenuController extends BaseController
{
    public function index($menu)
    {
        return app(MenuService::class)->get($menu);
    }
}
