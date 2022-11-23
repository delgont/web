<?php

namespace Web;

trait Commentable
{
    public function comments()
    {
        return $this->morphMany('Delgont\Cms\Models\Comment\Comment', 'commentable');
    }

    public function comment($comment, $commenter = ['id' => null, 'type' => 'App\User'])
    {

    }
}