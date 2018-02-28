<?php

namespace App\Http\Controllers\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\Interfaces\ItemInterface;

class ItemController extends Controller
{
	private $items;

	public function __construct(ItemInterface $items)
    {
        $this->items = $items;
    }

    public function index()
    {
        return $this->items->list();
    }
}
