<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CharactersShowTest extends TestCase
{
    /**
     * Test succesful response with same structure as marvel api
     *
     * @return void
     */
    public function testSuccessfulResponse()
    {
        $this->json('GET', 'api/v1/public/characters', ['Accept' => 'application/json'])
             ->assertStatus(200)
             ->assertJsonStructure([
                "code",
                "status",
                "copyright",
                "attributionText",
                "attributionHTML",
                "etag",
                "data" => [
                    'offset',
                    'limit',
                    'total',
                    'count',
                    'results',
                ]
            ]);
    }
}
