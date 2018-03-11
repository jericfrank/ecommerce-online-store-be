<?php

namespace App\Http\Controllers\Checkout;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\Interfaces\CartInterface;

class CartController extends Controller
{
	protected $cart;

	public function __construct(CartInterface $cart)
    {
        $this->middleware('auth:api');

        $this->cart = $cart;
    }

    public function index()
    {
        return $this->cart->list();
    }

    public function store(Request $request)
    {
    	$data = $this->cart->create( $request->all() );

    	return response()->json( $data, 201 );
    }

    public function destroy($id)
    {
    	$this->cart->destroy($id);
    	
    	return response()->json(null, 204);
    }
}
