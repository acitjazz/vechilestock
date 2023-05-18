<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Motorcycle;
use App\Models\Vechile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class VechileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $years = [];
        for ($i = 0; $i < 11; $i++) {
            $years[] = Carbon::now()->subYear($i)->format('Y');
        }
        $color = array('Red','Black','Green','Blue','White','Yellow');
        $min = 8000000;
        $max = 200000000;
        $cars = Car::pluck('_id')->toArray();
        $motorcycles = Motorcycle::pluck('_id')->toArray();
        for ($x = 0; $x <= 10; $x++) {
            $vechile =  Vechile::create(
                [
                    'model_id'=>  $cars[array_rand($cars)],
                    'type'=>  'Car',
                    'year' => $years[array_rand($years)],
                    'color' => $color[array_rand($color)],
                    'price' => mt_rand ($min*10, $max*10) / 10,
                    'qty' => rand(1,100),
                ]
            );
            $this->command->info('Creating...' . $vechile->type);
        }
        for ($x = 0; $x <= 10; $x++) {
            $vechile =  Vechile::create(
                [
                    'model_id'=>  $motorcycles[array_rand($motorcycles)],
                    'type'=>  'Motorcycle',
                    'year' => $years[array_rand($years)],
                    'color' => $color[array_rand($color)],
                    'price' => mt_rand ($min*10, $max*10) / 10,
                    'qty' => rand(1,100),
                ]
            );
            $this->command->info('Creating...' . $vechile->type);
        }
        cache()->flush();
    }
}
