<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CUserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStore()
    {

        $data = [
            'name'              => 'Nome do usuário',
            'cpf'               => '12312312312',
            'id_country'        => 1,
            'id_city'           => 1
        ];
        $route = route("users.store", [], false);
        $response = $this->post($route, $data);
        $response->assertJsonStructure([
            'id',
            'name',
            'cpf',
            'created_at',
            'updated_at'
        ]);

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testShow()
    {
        $route = route("users.show", ['user' => 1], false);
        $response = $this->get($route);
        $response->assertJsonStructure([
            'id',
            'name',
            'country' => [
                'id',
                'name'
            ],
            'city' => [
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
            'name'       => 'Novo nome',
        ];
        $route = route("users.update", ['user' => 1], false);
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

        $route = route("users.destroy", ['user' => 2], false);
        $response = $this->delete($route, []);

        $response->assertStatus(200);

    }

}
