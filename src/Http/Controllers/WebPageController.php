<?php

namespace Web\Http\Controllers;

use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Web\WebPage;

class WebPageController extends Controller
{
    private $webPage;
    
    protected $view;

    const DEFAULT_VIEW = 'page.index';
    const POST_PAGINATION = 3;

    public function __construct(WebPage $webPage)
    {
        $this->webPage = $webPage;
    }

    public function index($page)
    {
        $page = $this->webPage->show($page);
        $posts = $this->webPage->posts($page);

        $blade = cache($page->page_key.'_view', $this->getView());

        return (request()->expectsJson()) ? response()->json(['page' => $page, 'posts' => $posts]) : view($blade, compact(['page', 'posts']));

    }


    public function child($child)
    {
        $parentPage = request('child');
        $childPage = request('child');

        $page = $this->webPage->show($childPage);
        $posts = $this->webPage->posts($page);

        $blade = cache($page->page_key.'_view', $this->getView());

        return (request()->expectsJson()) ? response()->json(['page' => $page, 'posts' => $posts]) : view($blade, compact(['page', 'posts']));

    }

    protected function setView($view)
    {
        $this->view = $view;
    }

    private function getView() : string 
    {
        return ($this->view) ? $this->view : self::DEFAULT_VIEW;
    }
        
}