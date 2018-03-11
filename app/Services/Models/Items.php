<?php

namespace App\Services\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Services\Models\Price;

class Items extends Model
{
	use Searchable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'category_id', 'created_by',
    ];

	protected $table = 'items';

    public function price()
    {
        return $this->hasOne( Price::class, 'item_id', 'id' );
    }
}