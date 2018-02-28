<?php

namespace App\Services\Repositories;

use App\Services\Models\Items;
use App\Services\Interfaces\ItemInterface;
use App\Services\Repositories\BaseRepository;

class ItemRepository extends BaseRepository implements ItemInterface
{
    public function __construct(Items $items)
    {
        $this->model = $items;
    }

    public function list()
    {
        return $this->model->all();
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }
}