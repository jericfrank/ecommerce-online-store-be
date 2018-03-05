<?php

namespace App\Services\Repositories;

use App\Services\Models\Category;
use App\Services\Interfaces\CategoryInterface;
use App\Services\Repositories\BaseRepository;

use Auth;

class CategoryRepository extends BaseRepository implements CategoryInterface
{
    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function list()
    {
        return $this->model->all();
    }

    public function create(array $attributes)
    {
        return Auth::user()->category()->create($attributes);
    }
}