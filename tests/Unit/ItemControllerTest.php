<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\Models\Items;
use App\Services\Models\User;
use Laravel\Passport\Passport;

use Mockery as m;

class ItemControllerTest extends TestCase
{
    public function setUp() {
        parent::setUp();
    
        Passport::actingAs(
            new User([ 'name' => 'test' ]),
            [ 'web' ]
        );
    
        $this->itemInterface = m::mock( 'App\Services\Interfaces\ItemInterface' );
    }

    public function testIndex()
    {
    	$data = [
            // response data
        ];

    	$this->itemInterface->shouldReceive( 'list' )->once()->andReturn( $data );

        $this->app->instance( 'App\Services\Interfaces\ItemInterface', $this->itemInterface );
    
        $expect = $this->call( 'GET', '/api/products/items' );

        $expect->assertStatus( 200 )->assertExactJson( $data );
    }

    public function testStore()
    {
        $payload = [
            'name'        => 'test',
            'description' => 'test',
            'category_id' => 1,
            'created_by'  => \Auth::user()->id
        ];

        $this->itemInterface->shouldReceive( 'create' )->once()->with( $payload )->andReturn( [] );

        $this->app->instance( 'App\Services\Interfaces\ItemInterface', $this->itemInterface );
        
        $expect = $this->call( 'POST', '/api/products/items', [
            'name'        => 'test',
            'description' => 'test',
            'category_id' => 1
        ] );

        $expect->assertStatus( 201 )->assertJson( [] );
    }

    public function testStoreError()
    {
        $payload = [
            'name'        => '',
            'description' => '',
            'category_id' => null
        ];

        $expect = $this->call( 'POST', '/api/products/items', $payload );

        $expect->assertStatus( 422 )->assertJsonStructure([
            'name'        => [],
            'description' => [],
            'category_id' => []
        ]);
    }

    public function tearDown() {
        m::close();
    }
}
