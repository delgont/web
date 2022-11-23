<?php
namespace Web\Support\Controllers;

use Web\Support\Controllers\Concerns\ShowsPage;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


abstract class PageController
{
    use ValidatesRequests, AuthorizesRequests, ShowsPage;

}