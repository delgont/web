<?php
namespace Web\Support\Controllers;

use Delgont\Cms\Models\Page\Page;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


abstract class HomePageController
{
    use ValidatesRequests, AuthorizesRequests;

    /**
     * The view for displaying the page content.
     *
     * @var string
     */
    protected $pageView = 'index';

     /**
     * The page key for the home or main page.
     *
     * @var string
     */
    protected $key = 'home';

    /**
     * Show the page .
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = Page::where('page_key', $this->getkey())->firstOrFail();
        return (request()->expectsJson()) ? response()->json($page) : view($this->getPageView(), compact(['page']));
    }

    protected function getKey() : string
    {
        return $this->key;
    }

    protected function setKey($key) : void
    {
        $this->key = $key;
    }

    protected function getPageView() : string
    {
        return $this->pageView;
    }

    protected function setPageView($view) : void
    {
        $this->pageView = $view;
    }

}