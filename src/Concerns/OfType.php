<?php

namespace Web\Concerns;


use Delgont\Cms\Models\Post\Post as WebPost;
use Delgont\Cms\Models\Post\PostType;

trait OfType
{
    /**
     * Get Posts of aspecific type
     * @param mixed $type
     * @param array $relations
     * @param boolean $paginate
     */
    public function getPostsOfType($type = null, $relations = [], $paginate = true)
    {
        if (!is_null($type)) {
            # code...
            return WebPost::ofType($type)->with((count($relations) > 0) ? $relations : $this->OfTypeRelations())->paginate($this->OfTypePagination(), $this->OfTypeAttributes());
        }
        return null;
    }

    public function getPostOfType()
    {
        
    }

    protected function OfTypeRelations()
    {
        return [
            'posttype',
            'categories',
            'icon',
            'author'
        ];
    }

    protected function OfTypePagination()
    {
        return config('web.of_type_pagination', 4);
    }

    protected function OfTypeAttributes()
    {
        return ['id', 'post_title', 'extract_text', 'post_featured_image', 'slug', 'url', 'type', 'created_by', 'post_type_id'];
    }


}