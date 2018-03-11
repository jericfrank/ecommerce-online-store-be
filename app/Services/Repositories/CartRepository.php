<?php

namespace App\Services\Repositories;

use App\Services\Models\Cart;
use App\Services\Interfaces\CartInterface;
use App\Services\Repositories\BaseRepository;

use Auth;

class CartRepository extends BaseRepository implements CartInterface
{
    public function __construct(Cart $model)
    {
        $this->model = $model;
    }

    public function list()
    {
        return Auth::user()->cart()->with('item')->get();
    }

    public function create(array $attributes)
    {
        return Auth::user()->cart()->create($attributes);
    }

    public function destroy($id)
    {
        return Auth::user()->cart()->find($id)->delete($id);
    }
}