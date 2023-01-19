<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthController extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_success()
    {

        $email = 'mrjohn@gmail.com';
        $password = 'password';

        $response = $this->post(route('signin'), [
            'email' => $email,
            'password' => $password
        ]);

        $response->assertStatus(200);
    }

    public function test_login_failed()
    {
        $email = 'johndoe@dev.com';
        $password = 'password';

        $response = $this->post(route('signin'), [
            'email' => $email,
            'password' => $password
        ]);

        $response->assertStatus(401);
    }
}
