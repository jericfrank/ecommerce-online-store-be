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
        $this->middleware('auth:api')->except('index', 'category', 'search');

        $this->items = $items;
    }

    public function index(Request $request)
    {
        return $this->items->list( $request->query( 'per_page' ) );
    }

    public function category(Request $request, $id)
    {
        return $this->items->findBy(
            [ 'category_id', '=', $id ],
            $request->query( 'per_page' )
        );
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

    public function search(Request $request)
    {
        return $this->items->search( $request->query( 'query' ), $request->query( 'per_page' ) );
    }
}
