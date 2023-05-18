<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker = Faker::create();
        // dd($faker->word());
        $passenger = array(5,7,9,2,4);
        $type = array('MPV','SPORT CAR','SUV','HATCHBACK','CROSSOVER','SEDAN');
        $machine = array('Gasoline','Diesel','Electric');
        for ($x = 0; $x <= 20; $x++) {
            $car =  Car::create(
                [
                    'passenger' => $passenger[array_rand($passenger)],
                    'type' => $type[array_rand($type)],
                    'machine' => $machine[array_rand($machine)],
                ]
            );

            $this->command->info('Creating...' . $car->type);
        }
        cache()->flush();
    }
}
