<?php
namespace Web;

use Illuminate\Database\Eloquent\Model;

use Delgont\Cms\Models\Concerns\Iconable;
use Delgont\Cms\Models\Concerns\HasOptions;

class Group extends Model
{
   use Iconable, HasOptions;

   public function scopeWithOptions($query)
   {
      return $this->query->with(['options']);
   }
  
}