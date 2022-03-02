<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BCityTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStore()
    {

        $data = [
            'id_country' => 1,
            'name'       => 'Nome da cidade',
        ];
        $route = route("cities.store", [], false);
        $response = $this->post($route, $data);
        $response->assertJsonStructure([
            'id',
            'name',
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
        $route = route("cities.show", ['city' => 1], false);
        $response = $this->get($route);
        $response->assertJsonStructure([
            'id',
            'name',
            'country' => [
                'id',
                'name'
            ],
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
            'id_country' => 1,
            'name'       => 'Nova cidade',
        ];
        $route = route("cities.update", ['city' => 1], false);
        $response = $this->put($route, $data);
        $response->assertJsonStructure([
            'id',
            'name',
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

        $route = route("cities.destroy", ['city' => 2], false);
        $response = $this->delete($route, []);

        $response->assertStatus(200);

    }

}
