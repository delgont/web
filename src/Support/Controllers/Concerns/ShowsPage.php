<?php
namespace Web\Support\Controllers\Concerns;
use Delgont\Cms\Models\Page\Page;
use Delgont\Cms\Models\Post\Post;


trait ShowsPage
{
    /**
     * The view for displaying the page content.
     *
     * @var string
     */
    protected $pageView = 'page';

    protected $showPagePosts = true;

    protected $postPagination = 4;


    /**
     * Show the page .
     * 
     * @param  String  $page_key
     * @return \Illuminate\Http\Response
     */
    public function index($page_key)
    {
        $page = Page::where('page_key', $page_key)->firstOrFail();
        $posts = $this->posts($page->post_type);
        return (request()->expectsJson()) ? response()->json(['page' => $page, 'posts' => $posts]) : view($this->getPageView(), compact(['page','posts']));
    }


    protected function getPageView() : string
    {
        return $this->pageView;
    }

    protected function setPageView($view) : void
    {
        $this->pageView = $view;
    }

    public function posts($post_type) : object
    {
        if($post_type != null){
            return Post::where('post_type', $post_type)
                        ->withOut(['updatedBy'])
                        ->with(['categories'])
                        ->paginate($this->getPostPagination());
        }
        return null;
    }

    private function getPostPagination()
    {
        return $this->postPagination;
    }

    protected function setPostPagination($pagination) : void 
    {
        $this->postPagination = $pagination;
    }
}