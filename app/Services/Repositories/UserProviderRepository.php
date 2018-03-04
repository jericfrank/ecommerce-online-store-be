<?php

namespace App\Services\Repositories;

use App\Services\Models\UserProvider;
use App\Services\Interfaces\UserProviderInterface;
use App\Services\Repositories\BaseRepository;

class UserProviderRepository extends BaseRepository implements UserProviderInterface
{
    /**
     * UserProviderRepository constructor.
     * @param UserProvider $article
     */
    public function __construct(UserProvider $provider)
    {
        $this->model = $provider;
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function findOneBy(array $attributes)
    {
        return $this->model->where([ $attributes ])->first();
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function findBy(array $attributes)
    {
        return $this->model->where([ $attributes ])->get();
    }

    /**
     * @param array $attributes
     * @param int $id
     * @return bool
     */
    public function update(array $attributes, int $id)
    {
        return $this->model->find($id)->update($attributes);
    }
}