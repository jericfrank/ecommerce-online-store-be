<?php

namespace App\Http\Controllers\Files;

use Illuminate\Http\Request;
use App\Http\Requests\ImageRequest;
use App\Http\Controllers\Controller;

use Storage, Image;

class ImageController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request)
    {
    	$content = $request->file('content');
        $path    = Storage::putFile('public', $content);

        $img = Image::make( storage_path( 'app/'.$path ) );
        $img->resize(50, 50);
        $img->save( storage_path( 'app/public/EfKMNeS27-50x50.png' ) );

    	return $img;
    }
}
