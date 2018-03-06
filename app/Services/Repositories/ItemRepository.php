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

    public function list($per_page = 15, $orderField = 'created_at', $order = 'desc')
    {
        return $this->model->orderBy( $orderField, $order)->paginate( $per_page );
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }
}