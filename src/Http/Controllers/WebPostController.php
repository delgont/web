<?php

namespace Web\Http\Controllers;

use Delgont\Cms\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Web\Services\WebPostService as WebPost;

class WebPostController extends Controller
{
    private $webPost;
    private $views = [];

    const DEFAULT_VIEWS = [
        'index' => 'post.index',
        'show' => 'post.show'
    ];

    public function __construct(WebPost $webPost)
    {
        $this->webPost = $webPost;
    }

    public function show()
    {
        $post = $this->webPost->show(request('postkey'));
        $others = $this->webPost->get($post->posttype->name);

        $blade = cache($post->post_key.'_view', $this->getViews()['show']);

        return (request()->expectsJson()) ? response()->json(['post' => $post]) : view($blade, compact(['post', 'others']));
    }


    protected function setViews($views)
    {
        $this->views = $views;
    }

    private function getViews() : array 
    {
        return ($this->views) ? $this->views : self::DEFAULT_VIEWS;
    }
}