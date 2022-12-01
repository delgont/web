<?php

namespace Web\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Web\Services\PostService;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }

    public function index()
    {
        $slug = request('slug');
        $post = app(PostService::class)->get($slug);

        $template = ($post->template) ? $post->template->path : $this->defaultTemplate();
        $postsOfType = app(PostService::class)->getPostsOfType((!is_null($post->postsOfType)) ? $post->postsOfType->postType->name : null);

        ///return response()->json(compact(['post', 'postsOfType', 'template']));
        return (request()->expectsJson()) ? response()->json(compact(['post', 'postsOfType'])) : ($slug == 'home') ? $this->home() : view($template, compact(['post', 'postsOfType']));
    }


    /**
     * Set home page view
     * @return view
     */
    protected function home()
    {
        return view('web.index');
    }

    /**
     * Set default page template
     * @return string
     */
    protected function defaultTemplate()
    {
        return 'web.templates.default-page';
    }
}
