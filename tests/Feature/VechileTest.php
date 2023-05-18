<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Motorcycle;
use App\Models\Vechile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class VechileTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndexShouldBeThrowAnErrorIfDoesntHaveToken()
    {
        $this->get(route('api.vechile.index'))
            ->assertStatus(self::HTTP_REDIRECT_UNAUTHORIZED);
    }

    public function testStoreShouldBeThrowAnErrorIfQtyYearPriceNotInteger()
    {
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.vechile.store'),['qty'=> 'satu','price'=> 'satu','year'=> 'satu'], [
            'Authorization' => 'Bearer ' .$token
        ]);
        $response
            ->assertStatus(422)
            ->assertJsonStructure(['errors'=>['price','qty','year']]);
    }

    public function testStoreShouldBeThrowAnErrorIfTypeNotCarOrMotorCycle()
    {
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.vechile.store'),['type'=> 'Kapal'], [
            'Authorization' => 'Bearer ' .$token
        ]);
        $response
            ->assertStatus(422)
            ->assertJsonStructure(['errors'=>['type']]);
    }


    public function testStoreShouldBeThrowAnErrorIfModelIdOfTypeCarNotFound()
    {

        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.vechile.store'),['model_id'=> 'tes','type'=>'Car'], [
            'Authorization' => 'Bearer ' .$token
        ]);
        $response
        ->assertStatus(422)
        ->assertJsonStructure(['errors'=>['model_id']]);
    }


    public function testStoreShouldBeThrowAnErrorIfModelIdOfTypeMotorcyclerNotFound()
    {

        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.vechile.store'),['model_id'=> 'tes','type'=>'Motorcycle'], [
            'Authorization' => 'Bearer ' .$token
        ]);
        $response
        ->assertStatus(422)
        ->assertJsonStructure(['errors'=>['model_id']]);
    }

    public function testStoreVechileTypeCar()
    {
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.vechile.store'),
                    [
                        'model_id'=> Car::first()->id,
                        'type'=> 'Car',
                        'year'=> 2023,
                        'qty'=> 100,
                        'price'=> 200000000,
                        'color'=> 'Red',
                    ], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['success','data']);
    }


    public function testStoreVechileTypeMotorcycle()
    {
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.vechile.store'),
                    [
                        'model_id'=> Motorcycle::first()->id,
                        'type'=> 'Motorcycle',
                        'year'=> 2023,
                        'qty'=> 100,
                        'price'=> 200000000,
                        'color'=> 'Red',
                    ], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['success','data']);
    }
    public function testShowVechile()
    {
        $vechile = Vechile::first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('GET', route('api.vechile.show',$vechile->id),
                    [
                    ], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response->assertStatus(200);
    }

    public function testUpdateVechileShoulbeThrowAnErrorIfVechileIdNotFound()
    {
       // $vechile = Vechile::first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.vechile.update','123').'?_method=PATCH',
                    [
                        'model_id'=> Motorcycle::first()->id,
                        'type'=> 'Motorcycle',
                        'year'=> 2023,
                        'qty'=> 100,
                        'price'=> 200000000,
                        'color'=> 'Red',
                    ], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }

    public function testUpdateVechile()
    {
        $vechile = Vechile::first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.vechile.update',$vechile->id).'?_method=PATCH',
                    [
                        'model_id'=> Motorcycle::first()->id,
                        'type'=> 'Motorcycle',
                        'year'=> 2023,
                        'qty'=> 100,
                        'price'=> 200000000,
                        'color'=> 'Red',
                    ], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['success','data']);
    }
    public function testDeleteVechile()
    {
        $vechile = Vechile::first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('DELETE', route('api.vechile.delete',['vechile'=>$vechile->id]),
                    [], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['success','data']);
    }
    public function testRestoreVechileShouldBeThrowAnErrorIfVechileIdNotAvailbleAtTheTrash()
    {
        $vechile = Vechile::first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.vechile.restore',['vechile'=>$vechile->id]),
                    [], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }
    public function testRestoreVechile()
    {
        $vechile = Vechile::first();
        $vechile->delete();
        $vechile = Vechile::onlyTrashed()->first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('POST', route('api.vechile.restore',['vechile'=>$vechile->id]),
                    [], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['success','data']);
    }
    public function testDestroyVechileShouldBeThrowAnErrorIfVechileIdNotAvailbleAtTheTrash()
    {
        $vechile = Vechile::first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('DELETE', route('api.vechile.destroy',['vechile'=>$vechile->id]),
                    [], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(404)
            ->assertJsonStructure(['message']);
    }
    public function testDestroyVechile()
    {
        $vechile = Vechile::first();
        $vechile->delete();
        $vechile = Vechile::onlyTrashed()->first();
        $token = Auth::attempt(['email'=>env('DEMO_EMAIL'), 'password' => env('DEMO_PASSWORD')]);
        $response = $this->json('DELETE', route('api.vechile.destroy',['vechile'=>$vechile->id]),
                    [], [
                        'Authorization' => 'Bearer ' .$token
                    ]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['success','data']);
    }
}
