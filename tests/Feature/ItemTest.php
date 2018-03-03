<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\Models\User;
use Laravel\Passport\Passport;

use Mockery;

class ItemTest extends TestCase
{
    public function testIndex()
    {
        Passport::actingAs(
	        factory(User::class)->create(),
	        [ 'web' ]
	    );

    	$data = [];

    	$mock = Mockery::mock( App\Services\Interfaces\ItemInterface::class );
    	$mock->shouldReceive( $data )->andReturn( '' );

        $this->app->instance( App\Services\Interfaces\ItemInterface::class, $mock );

        $expect = $this->call( 'GET', '/api/products/items' );

        $expect->assertStatus( 200 )->assertJsonStructure( $data );
    }
}
