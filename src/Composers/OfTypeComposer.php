<?php

namespace Web\Composers;

use Illuminate\View\View;

use Web\Concerns\OfType;

class OfTypeComposer
{
    use OfType;

    public function compose(View $view, $type)
    {

        $view->with('hello', 'hello');
    }
    

}