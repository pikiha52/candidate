<?php

namespace Tests\Feature\Http\Controllers\Api\Candidate;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CandidateController extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_candidate()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L2FwaS92MS9hdXRoL3NpZ25pbiIsImlhdCI6MTY3NDA2NzMzMCwiZXhwIjoxNjc0MDcwOTMwLCJuYmYiOjE2NzQwNjczMzAsImp0aSI6ImM4anlxZWZyT0RRV1FiWkgiLCJzdWIiOiIxIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.UTuU5NCmA7FuTq28wOfl4Sc9TiVmm-Wsty4bsFoeTMY';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get(route('candidate.view'));

        $response->assertStatus(200);
    }

    public function test_index_candidate_failed()
    {
        $token = '123';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get(route('candidate.view'));

        $response->assertStatus(401);
    }

    public function test_store_candidate()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L2FwaS92MS9hdXRoL3NpZ25pbiIsImlhdCI6MTY3NDA2NzMzMCwiZXhwIjoxNjc0MDcwOTMwLCJuYmYiOjE2NzQwNjczMzAsImp0aSI6ImM4anlxZWZyT0RRV1FiWkgiLCJzdWIiOiIxIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.UTuU5NCmA7FuTq28wOfl4Sc9TiVmm-Wsty4bsFoeTMY';
        Storage::fake('local');
        $file = File::create('testing.pdf', 100);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->post(route('candidate.add'), [
            'name' => $this->faker->name(),
            'education' => $this->faker->words(6, true),
            'birthday' => $this->faker->date('Y-m-d'),
            'experience' => $this->faker->words(9, true),
            'last_position' => $this->faker->words(6, true),
            'applied_position' => $this->faker->words(7, true),
            'skils' => $this->faker->words(9, true),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'resume' => $file
        ]);

        $response->assertStatus(500);
    }

    public function test_show_candidate()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L2FwaS92MS9hdXRoL3NpZ25pbiIsImlhdCI6MTY3NDA2NzMzMCwiZXhwIjoxNjc0MDcwOTMwLCJuYmYiOjE2NzQwNjczMzAsImp0aSI6ImM4anlxZWZyT0RRV1FiWkgiLCJzdWIiOiIxIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.UTuU5NCmA7FuTq28wOfl4Sc9TiVmm-Wsty4bsFoeTMY';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token
        ])->get(route('candidate.read', 1));

        $response->assertStatus(200);
    }

    public function test_update_candidate()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L2FwaS92MS9hdXRoL3NpZ25pbiIsImlhdCI6MTY3NDA2NzMzMCwiZXhwIjoxNjc0MDcwOTMwLCJuYmYiOjE2NzQwNjczMzAsImp0aSI6ImM4anlxZWZyT0RRV1FiWkgiLCJzdWIiOiIxIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.UTuU5NCmA7FuTq28wOfl4Sc9TiVmm-Wsty4bsFoeTMY';
        Storage::fake('local');
        $file = File::create('testing.pdf', 100);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->post(route('candidate.edit', 1), [
            'name' => $this->faker->name(),
            'education' => $this->faker->words(6, true),
            'birthday' => $this->faker->date('Y-m-d'),
            'experience' => $this->faker->words(9, true),
            'last_position' => $this->faker->words(6, true),
            'applied_position' => $this->faker->words(7, true),
            'skils' => $this->faker->words(9, true),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'resume' => $file
        ]);

        $response->assertStatus(500);
    }

    public function test_delete_candidate()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0L2FwaS92MS9hdXRoL3NpZ25pbiIsImlhdCI6MTY3NDA2NzMzMCwiZXhwIjoxNjc0MDcwOTMwLCJuYmYiOjE2NzQwNjczMzAsImp0aSI6ImM4anlxZWZyT0RRV1FiWkgiLCJzdWIiOiIxIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.UTuU5NCmA7FuTq28wOfl4Sc9TiVmm-Wsty4bsFoeTMY';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token
        ])->delete(route('candidate.delete', 3));

        $response->assertStatus(200);
    }
}
