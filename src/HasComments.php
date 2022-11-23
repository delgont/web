<?php

namespace Web;

trait HasComments
{
    public function comments()
    {
        return $this->morphMany('Delgont\Cms\Models\Comment\Comment', 'commentable');
    }
}