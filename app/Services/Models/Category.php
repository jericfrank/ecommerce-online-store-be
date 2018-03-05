<?php

namespace App\Services\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Auth;

class Category extends Model
{
	use SoftDeletes;

	protected $fillable = [
        'name', 'description'
    ];

	protected $table = 'category';
}