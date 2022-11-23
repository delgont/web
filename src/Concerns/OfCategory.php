<?php

namespace Web\Concerns;


use Delgont\Cms\Models\Post\Post as WebPost;

trait OfCategory
{
    /**
     * Get Posts of aspecific category
     * @param mixed $category
     * @param array $relations
     * @param boolean $paginate
     */
    public function getPostsOfCategory($category, $relations = [], $paginate = true)
    {
        return WebPost::ofCategory($category)->with((count($relations) > 0) ? $relations : $this->OfCategoryRelations())->paginate($this->OfCategoryPagination(), $this->OfCategoryAttributes());
    }

    protected function OfCategoryRelations()
    {
        return [
            'posttype',
            'categories',
            'icon',
            'author'
        ];
    }

    protected function OfCategoryPagination()
    {
        return config('web.of_type_pagination', 4);
    }

    protected function OfCategoryAttributes()
    {
        return ['id', 'post_title', 'extract_text', 'post_featured_image', 'slug', 'url', 'type', 'created_by', 'post_type_id'];
    }


}