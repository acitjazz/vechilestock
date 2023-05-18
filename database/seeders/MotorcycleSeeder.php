<?php

namespace Database\Seeders;

use App\Models\Motorcycle;
use Illuminate\Database\Seeder;

class MotorcycleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transmission = array('Matic','Manual');
        $suspension = array('Mono Shock','Dual Shock');
        $machine = array('Gasoline','Electric');
        for ($x = 0; $x <= 20; $x++) {
            $motorcycle =  Motorcycle::create(
                [
                    'transmission' => $transmission[array_rand($transmission)],
                    'suspension' => $suspension[array_rand($suspension)],
                    'machine' => $machine[array_rand($machine)],
                ]
            );

            $this->command->info('Creating...' . $motorcycle->machine);
        }
        cache()->flush();
    }
}
