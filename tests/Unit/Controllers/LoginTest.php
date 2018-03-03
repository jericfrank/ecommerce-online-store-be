<?php

namespace Tests\Unit\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\Models\User;
use Laravel\Passport\Passport;

use Mockery as m;

class LoginTest extends TestCase
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

        $this->app->instance( 'App\Services\Interfaces\UserInterface', $mock );

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
            factory(User::class)->create(),
            [ 'web' ]
        );

        $expect = $this->call( 'GET', '/api/logout' );

        $expect->assertStatus( 204 );
    }

    public function tearDown() {
        m::close();
    }
}
