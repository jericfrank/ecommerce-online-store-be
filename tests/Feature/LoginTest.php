<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\Models\User;

class LoginTest extends TestCase
{
    public function testLoginSuccess()
    {
    	$headers = [
    		'Content-Type' => 'application/json'
    	];
    	$payload = [
    		'email'    => 'guns@gmail.com',
    		'password' => 'secret'
    	];

    	$expect = $this->withHeaders( $headers )->json( 'POST', '/api/login', $payload );

    	$response = [
    		'user' => [
    			'id',
    			'name',
    			'email',
    			'created_at',
    			'updated_at',
    			'providers' => [
    				[
    					'id',
    					'avatar',
    					'provider',
    					'provider_id',
    					'user_id',
    					'created_at',
    					'updated_at'
    				]
    			],
    			'provider'
    		],
    		'token'
    	];

        $expect
            ->assertStatus( 200 )
            ->assertJsonStructure( $response );
    }
}
