<?php

namespace Tests\Feature;

use App\Models\Motorcycle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class MotorCycleTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndexShouldBeThrowAnErrorIfDoesntHaveToken()
    {
        $this->get(route('api.motorcycle.index'))
            ->assertStatus(self::HTTP_REDIRECT_UNAUTHORIZED);
    }

    public function testStoreMotorcycle()
    {
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.motorcycle.store'),
                    [
                        'transmission'=> $this->faker->word(),
                        'suspension'=> $this->faker->word(),
                        'machine'=>  $this->faker->word(),
                    ], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['success','data']);
    }

    public function testShowMotorcycle()
    {
        $motorcycle = Motorcycle::first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('GET', route('api.motorcycle.show',$motorcycle->id),
                    [
                    ], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response->assertStatus(200);
    }

    public function testUpdateMotorcycleShoulbeThrowAnErrorIfMotorcycleIdNotFound()
    {
       // $motorcycle = Motorcycle::first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.motorcycle.update','123').'?_method=PATCH',
                    [
                        'transmission'=> $this->faker->word(),
                        'suspension'=> $this->faker->word(),
                        'machine'=>  $this->faker->word(),
                    ], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }
    public function testUpdateMotorcycle()
    {
        $motorcycle = Motorcycle::first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.motorcycle.update',$motorcycle->id).'?_method=PATCH',
                    [
                        'transmission'=> $this->faker->word(),
                        'suspension'=> $this->faker->word(),
                        'machine'=>  $this->faker->word(),
                    ], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['success','data']);
    }
    public function testDeleteMotorcycle()
    {
        $motorcycle = Motorcycle::first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('DELETE', route('api.motorcycle.delete',['motorcycle'=>$motorcycle->id]),
                    [], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['success','data']);
    }
    public function testRestoreMotorcycleShouldBeThrowAnErrorIfMotorcycleIdNotAvailbleAtTheTrash()
    {
        $motorcycle = Motorcycle::first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.motorcycle.restore',['motorcycle'=>$motorcycle->id]),
                    [], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }
    public function testRestoreMotorcycle()
    {
        $motorcycle = Motorcycle::first();
        $motorcycle->delete();
        $motorcycle = Motorcycle::onlyTrashed()->first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.motorcycle.restore',['motorcycle'=>$motorcycle->id]),
                    [], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['success','data']);
    }
    public function testDestroyMotorcycleShouldBeThrowAnErrorIfMotorcycleIdNotAvailbleAtTheTrash()
    {
        $motorcycle = Motorcycle::first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('DELETE', route('api.motorcycle.destroy',['motorcycle'=>$motorcycle->id]),
                    [], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }
    public function testDestroyMotorcycle()
    {
        $motorcycle = Motorcycle::first();
        $motorcycle->delete();
        $motorcycle = Motorcycle::onlyTrashed()->first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('DELETE', route('api.motorcycle.destroy',['motorcycle'=>$motorcycle->id]),
                    [], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['success','data']);
    }
}
