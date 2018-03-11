<?php

namespace App\Services\Repositories;

use App\Services\Models\Cart;
use App\Services\Interfaces\CartInterface;
use App\Services\Repositories\BaseRepository;

class CartRepository extends BaseRepository implements CartInterface
{
    public function __construct(Cart $model)
    {
        $this->model = $model;
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