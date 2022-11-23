<?php

namespace Web\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Web\Services\PostService;
use Web\Services\MenuService;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $postService;
    private $menu;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
        $this->menu = new MenuService();
    }

    public function index()
    {
        $slug = request('slug');
        $post = $this->getPost($slug);

        $template = ($post->template) ? $post->template->path : $this->defaultTemplate();
        $postsOfType = $this->postService->getPostsOfType((!is_null($post->postsOfType)) ? $post->postsOfType->postType->name : null);

        ///return response()->json(compact(['post', 'postsOfType', 'template']));
        return (request()->expectsJson()) ? response()->json(compact(['post', 'postsOfType'])) : ($slug == 'home') ? $this->home() : view($template, compact(['post', 'postsOfType']));
    }

    protected function getPost($slug)
    {
        return $this->postService->get($slug);
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
