<?php

namespace App\Http\Controllers\Products;

use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;

use App\Http\Controllers\Controller;

use App\Services\Interfaces\ItemInterface;

use Auth;

class ItemController extends Controller
{
	protected $items;

	public function __construct(ItemInterface $items)
    {
        $this->items = $items;
    }

    public function index()
    {
        return $this->items->list();
    }

    public function store(ItemRequest $request)
    {
    	$attributes = [
    		'name'        => $request->get('name'),
    		'description' => $request->get('description'),
    		'category_id' => $request->get('category_id'),
    		'created_by'  => Auth::user()->id
    	];

        return response()->json(
            $this->items->create( $attributes ),
            201
        );
    }
}
