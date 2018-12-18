<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    private $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL21vdmllcy1hcGlzXC9wdWJsaWNcL2FwaVwvdjFcL2F1dGhcL2xvZ2luIiwiaWF0IjoxNTQ1MTM4Mjk2LCJleHAiOjE1NDUxNDE4OTYsIm5iZiI6MTU0NTEzODI5NiwianRpIjoicmFZM21INEs4T2xGZ0dmYSIsInN1YiI6MSwicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.1YWwgSjbLJKiUlmAn42mgK2QYnTzOM8EzlRXrN3tnLU';

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {

        // movies list
        $response = $this->json('GET', 'api/v1/movies', ['token' => $this->token]);
        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
            ]);

        // movies create
        $response = $this->json('POST', 'api/v1/movies/save', ['token' => $this->token,
            'title' => 'Aquaman',
            'description' => 'Arthur Curry learns that he is the heir to the underwater kingdom of Atlantis, and must step forward to lead his people and be a hero to the world.',
            'rating' => '7.9',
            'director' => 'James Wan',
            'year' => '2018',
            'gross_profi' => '1.7M',
            'actors_list' => '1,2,3',
            'genre' => 'Romanice'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
            ]);

        // movies Edit
        $response = $this->json('POST', 'api/v1/movies/1/edit', ['token' => $this->token,
            'title' => 'Aquaman',
            'description' => 'Arthur Curry learns that he is the heir to the underwater kingdom of Atlantis, and must step forward to lead his people and be a hero to the world.',
            'rating' => '7.9',
            'director' => 'James Wan',
            'year' => '2018',
            'gross_profi' => '1.7M',
            'actors_list' => '1,2,3',
            'genre' => 'Romanice'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
            ]);

        // movies Show
        $response = $this->json('GET', 'api/v1/movies/1/show', ['token' => $this->token]);


        $response
            ->assertStatus(200)
            ->assertJson([
                'error' => false,
            ]);

    }


}
