<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\Models\Items;
use App\Services\Models\User;
use Laravel\Passport\Passport;

use Mockery;

class ItemTest extends TestCase
{
    public function setUp() {
        parent::setUp();
    
        Passport::actingAs(
            factory(User::class)->create(),
            [ 'web' ]
        );
    }

    public function testIndex()
    {
    	$data = [
            // response data
        ];

    	$mock = Mockery::mock( 'App\Services\Interfaces\ItemInterface' );
    	$mock->shouldReceive( 'list' )->once()->andReturn( $data );

        $this->app->instance( 'App\Services\Interfaces\ItemInterface', $mock );
    
        $expect = $this->call( 'GET', '/api/products/items' );

        $expect->assertStatus( 200 )->assertExactJson( $data );
    }

    public function tearDown() {
        Mockery::close();
    }
}
