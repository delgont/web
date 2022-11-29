<?php

namespace Web\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as MainController;

use Web\Services\PostService;
use Web\Services\MenuService;


class BaseController extends MainController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
}
