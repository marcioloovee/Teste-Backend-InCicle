<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ACountryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStore()
    {

        $data = [
            'name' => 'Nome do estado',
            'code' => 'SG'
        ];
        $route = route("countries.store", [], false);
        $response = $this->post($route, $data);
        $response->assertJsonStructure([
            'id',
            'name',
            'code',
            'created_at',
            'updated_at'
        ]);

        $response->assertStatus(200);

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testShow()
    {
        $route = route("countries.show", ['country' => 1], false);
        $response = $this->get($route);
        $response->assertJsonStructure([
            'id',
            'name',
            'code',
            'created_at',
            'updated_at'
        ]);

        $response->assertStatus(200);

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdate()
    {

        $data = [
            'name' => 'Novo estado',
            'code'  => 'AA'
        ];
        $route = route("countries.update", ['country' => 1], false);
        $response = $this->put($route, $data);
        $response->assertJsonStructure([
            'id',
            'name',
            'code',
            'created_at',
            'updated_at'
        ]);

        $response->assertStatus(200);

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDestroy()
    {

        $route = route("countries.destroy", ['country' => 2], false);
        $response = $this->delete($route, []);

        $response->assertStatus(200);

    }

}
