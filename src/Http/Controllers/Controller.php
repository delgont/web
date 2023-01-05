<?php

namespace Web\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Web\Services\PostService;

//Repositories
use Delgont\Cms\Repository\Post\PostRepository;
use Delgont\Cms\Repository\Template\TemplateRepository;

//Models
use Delgont\Cms\Models\Post\Post;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $repository = null;
    protected $postRepository = null;
    protected $templateRepository = null;
    protected $post = null;
    protected $slug = null;

    protected $postRelations = [];
    
    public function __construct()
    {
        $this->postRepository = app(PostRepository::class)->setKey('slug');
        $this->templateRepository = app(TemplateRepository::class)->fromCache();
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

        //Get post by its slug
        $post = $this->postRepository->fromCache()->findOrFail($slug);
        $this->postRepository->setPost($post);

        //Get view template path
        $template = ($slug === 'home') ? $this->home() : $this->getTemplatePath($post->template_id);

        //Get the categories to which the post belongs to
        $categories = $this->postRepository->categories( $post );

        $postsOfType = $post->postsOfType()->first();

        $posts = ($postsOfType) ? $this->postRepository->paginated()->getPostsOfType($postsOfType->post_type_id) : $this->postRepository->paginated()->getChildren($post);
        
        return view($template, compact(['post', 'categories', 'posts']));
    }


    /**
     * Set home page view
     * @return view
     */
    protected function home()
    {
        return 'web.index';
    }

    /**
     * Set default page template
     * @return string
     */
    protected function defaultTemplate()
    {
        return 'web.templates.default-page';
    }

    protected function getTemplatePath($id)
    {
        return ($id) ? $this->templateRepository->getTemplatePath($id) : $this->defaultTemplate();
    }


}
