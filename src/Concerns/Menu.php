<?php

namespace Web\Concerns;


use Delgont\Cms\Models\Menu\Menu as Meno;

trait Menu
{
    public function get($menu_key)
    {
        return Meno::where('key',$menu_key)->withOrganisedMenuItems()->first();
    }

}