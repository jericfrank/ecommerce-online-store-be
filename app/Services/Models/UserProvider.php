<?php

namespace App\Services\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProvider extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'avatar', 'provider', 'provider_id', 'user_id',
    ];

	/**
     * Table name in database
     *
     * @var string
     */
    protected $table = 'user_providers';
}
