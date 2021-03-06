<?php

namespace App\Http\Controllers\Products;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Controller;

use App\Services\Interfaces\CategoryInterface;

class CategoryController extends Controller
{
	protected $category;

	public function __construct(CategoryInterface $category)
    {
        $this->middleware('auth:api')->except('index');

        $this->category = $category;
    }

    public function index()
    {
        return $this->category->list();
    }

    public function store(CategoryRequest $request)
    {
    	$data = $this->category->create( $request->all() );

    	return response()->json( $data, 201 );
    }
}
