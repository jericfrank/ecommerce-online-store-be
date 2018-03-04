<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\Models\User;
use Laravel\Passport\Passport;

use Mockery as m;

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

        $mock = m::mock( 'App\Services\Interfaces\UserInterface' );
        $mock->shouldReceive( 'attempt' )->once()->with( $payload )->andReturn( true );
        $mock->shouldReceive( 'user' )->once()->andReturn( m::mock( new User ) );
        $mock->shouldReceive( 'token' )->once()->andReturn( 'jwtToken' );

        $mockProvider = m::mock( 'App\Services\Interfaces\UserProviderInterface' );
        $mockProvider->shouldReceive( 'findBy' )->once()->with( [ 'provider', '=', 'internal' ] )->andReturn( [] );

        $this->app->instance( 'App\Services\Interfaces\UserInterface', $mock );
        $this->app->instance( 'App\Services\Interfaces\UserProviderInterface', $mockProvider );

        $expect = $this->call( 'POST', '/api/login', $payload );

        $expect->assertStatus( 200 )->assertJsonStructure( [ 'user', 'token' ] );
    }

    public function testLoginError()
    {
        $payload = [
            'email'    => 'test@gmail.com',
            'password' => 'test',
        ];

        $mock = m::mock( 'App\Services\Interfaces\UserInterface' );
        $mock->shouldReceive( 'attempt' )->once()->with( $payload )->andReturn( false );

        $this->app->instance( 'App\Services\Interfaces\UserInterface', $mock );

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
