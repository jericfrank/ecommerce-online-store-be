<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\Models\User;

use Mockery as m;
use StdClass;
use JWTAuth;

class LoginControllerTest extends TestCase
{
    public function testLoginSuccess()
    {
        $data = [
            'user'  => [],
            'token' => ''
        ];

        $payload = [
            'email'    => 'test@gmail.com',
            'password' => 'test',
        ];

        JWTAuth::shouldReceive( 'attempt' )->once()->with( $payload )->andReturn( 'jwtToken' );
        JWTAuth::shouldReceive( 'user' )->once()->andReturn( m::mock( new User ) );
        JWTAuth::shouldReceive( 'factory' )->once()->andReturn( m::self() )
            ->getMock()
            ->shouldReceive( 'getTTL' )->once()->andReturn( 3600 );

        $expect = $this->call( 'POST', '/api/login', $payload );

        $expect->assertStatus( 200 )->assertJsonStructure( [ 'user', 'token', 'token_type', 'expires_in' ] );
    }

    public function testLoginError()
    {
        $payload = [
            'email'    => 'test@gmail.com',
            'password' => 'test',
        ];

        JWTAuth::shouldReceive( 'attempt' )->once()->with( $payload )->andReturn( false );

        $expect = $this->call( 'POST', '/api/login', $payload );

        $expect->assertStatus( 401 )->assertSee( 'Unauthorized' );
    }

    public function testLogout()
    {
        Passport::actingAs(
            new User([ 'name' => 'test' ]),
            [ 'web' ]
        );
        
        $expect = $this->call( 'GET', '/api/logout' );

        $expect->assertStatus( 204 );
    }

    public function tearDown() {
        m::close();
    }
}
