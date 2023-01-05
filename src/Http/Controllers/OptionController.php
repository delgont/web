<?php

namespace Web\Http\Controllers;
use Web\Http\Controllers\BaseController;

use Delgont\Cms\Repository\Option\OptionRepository;




class OptionController extends BaseController
{
    protected $repository = null;

    public function __construct()
    {
        $this->repository = app(OptionRepository::class)->setKey('option_key');
    }

    /**
     * Get all the available options
     */
    public function index()
    {
        $options = $this->repository->all();
        return response()->json($options, 200);
    }

    public function show($key)
    {
        $option = $this->repository->fromCache()->find($key);
        return response()->json($option, 200);
    }

}
