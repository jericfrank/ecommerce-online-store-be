<?php

namespace App\Services\Interfaces;

use App\Services\Interfaces\BaseInterface;

interface CartInterface extends BaseInterface
{
	public function create(array $attributes);
}