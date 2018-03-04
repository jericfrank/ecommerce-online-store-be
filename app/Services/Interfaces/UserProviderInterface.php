<?php

namespace App\Services\Interfaces;

use App\Services\Interfaces\BaseInterface;

interface UserProviderInterface extends BaseInterface
{
	public function create(array $attributes);

	public function findOneBy(array $attributes);

	public function findBy(array $attributes);
}