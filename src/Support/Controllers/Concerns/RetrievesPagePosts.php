<?php
namespace Web\Support\Controllers\Concerns;
use Delgont\Cms\Models\Post\Post;

trait RetrievesPagePosts
{
    protected $postPagination = 4;

    public function posts($post_type) : array
    {
        if($post_type != null){
            return Post::where('post_type', $post_type)->paginate($this->getPostPagination());
        }
        return array();
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