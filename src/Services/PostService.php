<?php

namespace Web\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use Delgont\Cms\Models\Post\Post as WebPost;
use Delgont\Cms\Models\Category\Category as WebCategory;

use Web\Concerns\OfType;



class PostService
{
    use OfType;

    private $page;

    public function __construct()
    {
        $this->page = new WebPost();
    }

    public function get($slug)
    {
        return $this
        ->page
        ->with($this->getPostRelations())
        ->published('1')
        ->whereSlug($slug)
        ->firstOrFail($this->parentPostAttributes());
    }

    public function getPostRelations()
    {
        return [
            'template:id,path',
            'categories:id,name',
            'menu.menuitems',
            'author',
            'posts' => function($q){
                $q->with([
                    'categories'
                ])->get();
            },
            'comments' => function($query){
                $query->whereNull('parent_id')->paginate(10);
            }
        ];
    }

    private function parentPostAttributes()
    {
        return [
            'id',
            'post_title',
            'extract_text',
            'post_content',
            'post_featured_image',
            'template_id',
            'slug',
            'menu_id',
            'created_by',
            'commentable'
        ];
    }

    private function childrenPostAttributes()
    {
        return [
            'id',
            'post_title',
            'extract_text',
            'post_featured_image',
            'parent_id',
            'slug'
        ];
    }
}
