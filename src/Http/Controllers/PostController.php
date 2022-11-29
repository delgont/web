<?php

namespace Web\Http\Controllers;
use Web\Http\Controllers\BaseController;

use Web\Services\PostService;

use Web\Concerns\OfType;
use Web\Concerns\OfCategory;



class PostController extends BaseController
{
    use OfType, OfCategory;

    public function index($id)
    {
        $post = app(PostService::class)->get($id, [
            'id',
            'post_title',
            'post_content',
            'extract_text',
            'post_content',
            'post_featured_image',
            'slug',
            'menu_id',
            'created_by',
            'commentable'
        ], [
            'categories:id,name',
            'menu.menuitems',
            'author',
            'comments' => function($query){
                $query->whereNull('parent_id')->paginate(10);
            }
        ]);
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
    
}
