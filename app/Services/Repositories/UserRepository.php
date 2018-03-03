<?php

namespace App\Services\Repositories;

use App\Services\Models\User;
use App\Services\Interfaces\UserInterface;
use App\Services\Repositories\BaseRepository;

use Auth;

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
     * @return array
     */
    public function list()
    {
        return $this->model->with('providers')->get();
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

    /**
     * @param array $data
     * @return mixed
     */
    public function findOneBy(array $attributes)
    {
        return $this->model->where([ $attributes ])->with('providers')->first();
    }

    /**
     * @param array $credentials
     * @return mixed
     */
    public function attempt(array $credentials)
    {
        return Auth::attempt($credentials);
    }

    /**
     * @return current user
     */
    public function user()
    {
        return Auth::user();
    }
}