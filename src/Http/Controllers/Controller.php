<?php

namespace Web\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Web\Services\PostService;

use Delgont\Cms\Repository\Post\PostRepository;
use Delgont\Cms\Models\Post\Post;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $repository = null;
    protected $post = null;
    protected $slug = null;

    protected $postRelations = [];
    
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


    public function view()
    {
        $slug = request('slug');
        $postsPerSection = request('page') ?? 1;

        $this->repository = app(PostRepository::class)->setKey('slug');
        $post = $this->repository->fromCache()->find($slug);
        $this->repository->setPost($post);

        $template = ($slug === 'home') ? 'web.index' : $this->getTemplate($this->repository->templatePath());

        $categories = $this->repository->categories();
        $posts = $this->repository->ofType(null , $postsPerSection, 3) ?? $this->repository->children(null , $postsPerSection, 3);
        
        return view($template, compact(['post', 'categories', 'posts']));
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

    protected function getTemplate($path)
    {
        return $path ?? $this->defaultTemplate();
    }


}
