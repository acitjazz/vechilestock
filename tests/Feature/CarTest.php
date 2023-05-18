<?php

namespace Tests\Feature;

use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CarTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndexShouldBeThrowAnErrorIfDoesntHaveToken()
    {
        $this->get(route('api.car.index'))
            ->assertStatus(self::HTTP_REDIRECT_UNAUTHORIZED);
    }

    public function testStoreShouldBeThrowAnErrorIfPassengerNotInteger()
    {
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.car.store'),['passenger'=> 'satu'], [
            'Authorization' => 'Bearer ' .$token
        ]);
        $response
            ->assertStatus(422)
            ->assertJsonStructure(['errors'=>['passenger']]);
    }

    public function testStoreCar()
    {
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.car.store'),
                    [
                        'passenger'=> 8,
                        'type'=> $this->faker->word(),
                        'machine'=>  $this->faker->word(),
                    ], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['success','data']);
    }

    public function testShowCar()
    {
        $car = Car::first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('GET', route('api.car.show',$car->id),
                    [
                    ], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response->assertStatus(200);
    }

    public function testUpdateCarShoulbeThrowAnErrorIfCarIdNotFound()
    {
       // $car = Car::first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.car.update','123').'?_method=PATCH',
                    [
                        'passenger'=> 8,
                        'type'=> $this->faker->word(),
                        'machine'=>  $this->faker->word(),
                    ], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }
    public function testUpdateCar()
    {
        $car = Car::first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.car.update',$car->id).'?_method=PATCH',
                    [
                        'passenger'=> 8,
                        'type'=> $this->faker->word(),
                        'machine'=>  $this->faker->word(),
                    ], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['success','data']);
    }
    public function testDeleteCar()
    {
        $car = Car::first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('DELETE', route('api.car.delete',['car'=>$car->id]),
                    [], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['success','data']);
    }
    public function testRestoreCarShouldBeThrowAnErrorIfCarIdNotAvailbleAtTheTrash()
    {
        $car = Car::first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.car.restore',['car'=>$car->id]),
                    [], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }
    public function testRestoreCar()
    {
        $car = Car::first();
        $car->delete();
        $car = Car::onlyTrashed()->first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.car.restore',['car'=>$car->id]),
                    [], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['success','data']);
    }
    public function testDestroyCarShouldBeThrowAnErrorIfCarIdNotAvailbleAtTheTrash()
    {
        $car = Car::first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('DELETE', route('api.car.destroy',['car'=>$car->id]),
                    [], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }
    public function testDestroyCar()
    {
        $car = Car::first();
        $car->delete();
        $car = Car::onlyTrashed()->first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('DELETE', route('api.car.destroy',['car'=>$car->id]),
                    [], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['success','data']);
    }
}
