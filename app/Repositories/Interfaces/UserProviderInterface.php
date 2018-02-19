<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseInterface;

interface UserProviderInterface extends BaseInterface
{
	public function create(array $attributes);

	public function findOneBy(array $attributes);
}