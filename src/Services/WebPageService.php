<?php

namespace Web\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use Delgont\Cms\Models\Page\Page as WebPage;
use Delgont\Cms\Models\Category\Category as WebCategory;



class WebPageService
{
    /**
     * Get Page
     */
    public function show($key, $columns = '*', $with = [])
    {
        return (count($with)) ? WebPage::with($with)->wherePageKey($key)->firstOrFail($columns) : WebPage::wherePageKey($key)->firstOrFail($columns);
    }

    /**
     * Gets page with its posts (paginated)
     */
    public function with($key, $with = [], $withPosts = true)
    {
        if($withPosts){
            $page = WebPage::wherePageKey($key)->firstOrFail();
            $posts = $page->posts()->paginate(4);
            return array(
                'page' => $page,
                'posts' => $posts
            );
        }
        return 'hello';
        return WebPage::wherePageKey($key)->firstOrFail();
    }

    public function posts($page)
    {
        return $page->posts()->paginate($this->getPostPagination());
    }
    

    protected function getPostPagination() : string
    {
        return cache('page_post_pagination', 3);
    }
   
}