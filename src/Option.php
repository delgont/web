<?php

namespace Web;

use Illuminate\Database\Eloquent\Model;
use Delgont\Cms\Models\Concerns\Iconable;


class Option extends Model
{
    use Iconable;
    
    protected $table = 'options';
}
