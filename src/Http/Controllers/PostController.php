<?php

namespace Web\Http\Controllers;
use Web\Http\Controllers\BaseController;

use Web\Services\PostService;

use Web\Concerns\OfType;
use Web\Concerns\OfCategory;

use Delgont\Cms\Repository\Post\PostRepository;


class PostController extends BaseController
{
    use OfType, OfCategory;

    public function index($id)
    {
        $post = app(PostRepository::class)
        ->setCacheAttribute('slug')
        ->fromCache()
        ->find( $id, $this->parentPostAttributes(),  $this->getPostRelations() );
        return response()->json($post, 200);
    }

    public function children($id)
    {
        $posts = app(PostService::class)->children($id);
        return response()->json($posts, 200);
    }

    public function ofType($type)
    {
        $posts = $this->getPostsOfType($type);

        return response()->json($posts, 200);
    }

    public function ofCategory($category)
    {
        $posts = $this->getPostsOfCategory($category);
        return response()->json($posts, 200);
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
    
}
