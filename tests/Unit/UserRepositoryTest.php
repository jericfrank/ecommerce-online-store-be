<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\Repositories\UserRepository;
use App\Services\Models\User;
use Laravel\Passport\Passport;

use Auth;
use Mockery as m;

class UserRepositoryTest extends TestCase
{
    public function setUp() {
        parent::setUp();
    
        $this->user = m::mock( new User );
    	$this->acting = new User([ 'id' => 1, 'name' => 'test' ]);

    	Passport::actingAs(
            $this->acting,
            [ 'web' ]
        );
        
    }

    public function tearDown() {
        m::close();
    }

    public function testUser()
    {
    	$expect = new UserRepository( $this->user );

    	$this->assertEquals( $expect->user(), $this->acting );
    }

    public function testToken()
    {
    	Auth::shouldReceive( 'user' )->once()->andReturn( m::self() )
            ->getMock()
            ->shouldReceive( 'createToken' )->once()->with( 'web' )->andReturn( 'passportToken' );

    	$expect = new UserRepository( $this->user );

    	$this->assertEquals( $expect->token(), 'passportToken' );
    }
}
