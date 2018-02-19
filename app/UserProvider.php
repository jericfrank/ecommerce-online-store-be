<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProvider extends Model
{
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
