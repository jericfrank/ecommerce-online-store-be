<?php

namespace App\Services\Repositories;

use App\Services\Models\User;
use App\Services\Interfaces\UserInterface;
use App\Services\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserInterface
{
    /**
     * UserRepository constructor.
     * @param User $article
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        $attributes['password'] = bcrypt($attributes['password']);

        return $this->model->create($attributes);
    }
}