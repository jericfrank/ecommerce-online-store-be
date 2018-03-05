<?php

namespace App\Services\Interfaces;

use App\Services\Interfaces\BaseInterface;

interface CategoryInterface extends BaseInterface
{
	public function list();

	public function create(array $attributes);
}