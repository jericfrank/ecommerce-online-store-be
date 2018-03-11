<?php

namespace App\Services\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
	use SoftDeletes;

	protected $fillable = [
        'latest', 'previous'
    ];

	protected $table = 'item_price';
}