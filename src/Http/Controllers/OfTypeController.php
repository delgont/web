<?php
namespace Web\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Web\Services\PostService;

class OfTypeController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        $slug = request('slug');

        $post = $this->postService->get($slug);
        dd($post);
        $template = ($post->template) ? $post->template->path : 'web.templates.default-page';

        return view($template, compact(['post']));
    }
}
