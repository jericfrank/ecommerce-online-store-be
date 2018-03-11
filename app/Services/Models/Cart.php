<?php

namespace App\Services\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Services\Models\Items;

class Cart extends Model
{
	use SoftDeletes;

	protected $fillable = [ 'item_id' ];

	protected $table = 'cart';

	public function item()
	{
		return $this->hasOne( Items::class, 'id', 'item_id' );
	}
}
