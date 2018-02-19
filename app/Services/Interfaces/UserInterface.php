<?php

namespace App\Services\Interfaces;

use App\Services\Interfaces\BaseInterface;

interface UserInterface extends BaseInterface
{
	public function create(array $attributes);
}