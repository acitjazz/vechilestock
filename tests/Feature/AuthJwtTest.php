<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthJwtTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use WithFaker;

    public function testLogin()
    {

        $response = $this->json('POST', route('api.auth.login'), [
            'email' => env('DEMO_EMAIL'),
            'password' => env('DEMO_PASSWORD')
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'user',
                'status',
                'authorisation' => [
                    'token',
                    'type'
                ]
            ]);
    }

    public function testRegister()
    {

        $response = $this->json('POST', route('api.auth.register'), [
            'name' =>  $this->faker->name(),
            'email' =>  $this->faker->email(),
            'password' => env('DEMO_PASSWORD'),
            'cofirm_password' => env('DEMO_PASSWORD'),
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'user',
                'status',
                'authorisation' => [
                    'token',
                    'type'
                ]
            ]);
    }

    public function testLogout()
    {

        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.auth.logout'), [], [
            'Authorization' => 'Bearer ' .$token
        ]);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'status' => 'success',
                'message' => 'Successfully logged out',
            ]);

    }

    public function testRefresh()
    {

        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.auth.refresh'), [], [
            'Authorization' => 'Bearer ' .$token
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'user',
                'status',
                'authorisation' => [
                    'token',
                    'type'
                ]
            ]);

    }
}
