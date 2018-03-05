<?php

namespace App\Services\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Services\Models\UserProvider;
use App\Services\Models\Category;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'deleted_at'
    ];

    /**
     * Get the user providers for the user.
     */
    public function providers()
    {
        return $this->hasMany( UserProvider::class, 'user_id', 'id' );
    }

    /**
     * Get the user providers for the user.
     */
    public function category()
    {
        return $this->hasMany( Category::class, 'created_by', 'id' );
    }
}
