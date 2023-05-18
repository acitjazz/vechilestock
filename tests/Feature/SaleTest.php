<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class SaleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndexShouldBeThrowAnErrorIfDoesntHaveToken()
    {
        $this->get(route('api.sale.index'))
            ->assertStatus(self::HTTP_REDIRECT_UNAUTHORIZED);
    }

    public function testStatistic()
    {
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('GET', route('api.sale.statistic'),[], [
            'Authorization' => 'Bearer ' .$token
        ]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['motorcycle'=>['total','provit','variants'],'car'=>['total','provit','variants']]);
    }
}
