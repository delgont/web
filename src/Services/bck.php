**
     * Get Posts of a specific type
     * 
     * @param string $type
     * @param mixed $category
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function all($type, $category = null) : Collection
    {
        return WebPost::whereHas('posttype', function($query) use ($type){
            $query->whereName($type);
        })->get();
    }

    /**
     * Get Posts of a specific type
     * 
     * @param string $type
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function get($type, $except = []) : LengthAwarePaginator
    {
        return WebPost::whereHas('posttype', function($query) use ($type){
            $query->whereName($type);
        })->paginate();
    }

    /**
     * Get Posts of a specific category
     * 
     * @param string $category
     * @param string $type
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function ofCategory($category, $type = null)
    {
        if(is_null($type)){
            return WebPost::whereHas('categories', function($query) use ($category){
                $query->whereName($category);
            })->paginate();
        }else{
            return WebPost::whereHas('categories', function($query) use ($category){
                $query->whereName($category);
            })->whereHas('posttype', function($query) use ($type){
                $query->whereName($type);
            })->paginate();
        }
    }

     /**
     * Get Posts of a specific type
     * 
     * @param string $type
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function ofType($type) : LengthAwarePaginator
    {
        return WebPost::whereHas('posttype', function($query) use ($type){
            $query->whereName($type);
        })->paginate();
    }

    /**
     * Get Single Post by its key
     * 
     * @param mixed $key
     * @return Delgont\Cms\Models\Post\Post
     */
    public function show($key) : WebPost
    {
        if(is_array($key)){
            return WebPost::where(function($query) use ($key) {
                foreach ($key as $column => $value) {
                    $query->where($column, $value);
                }
            })->firstOrFail();
        }
        return WebPost::where('post_key', $key)->firstOrFail();
    }