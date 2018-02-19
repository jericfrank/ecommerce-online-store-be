<?php

namespace App\Repositories;

use App\UserProvider;
use App\Repositories\Interfaces\UserProviderInterface;
use App\Repositories\BaseRepository;

class UserProviderRepository extends BaseRepository implements UserProviderInterface
{
    /**
     * UserProviderRepository constructor.
     * @param UserProvider $article
     */
    public function __construct(UserProvider $user)
    {
        $this->model = $user;
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
     * @param array $data
     * @return mixed
     */
    public function findOneBy(array $attributes)
    {
        return $this->model->where([ $attributes ])->first();
    }
}