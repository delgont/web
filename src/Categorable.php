<?php
namespace Web;

use Delgont\Cms\Models\Category\Category;

trait Categorable {

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorable');
    }

}