<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseInterface;

interface UserInterface extends BaseInterface
{
	public function create(array $attributes);
}