<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Motorcycle;
use App\Models\Sale;
use App\Models\Vechile;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vechilesdata = Vechile::whereHas('motorcycle')->orWhereHas('car')->pluck('_id');
        $vechiles = $vechilesdata->toArray();
        for ($x = 0; $x <= $vechilesdata->count(); $x++) {
            $vechile =  $vechiles[array_rand($vechiles)];
            $vechile = Vechile::find($vechile);
            $qty = rand(1,10);
            $sale =  Sale::create(
                [
                    'vechile_id'=> $vechile->id,
                    'model_id'=> $vechile->model_id,
                    'type'=>  $vechile->type,
                    'year' =>  $vechile->year,
                    'color' => $vechile->color,
                    'price' => $qty*$vechile->price,
                    'qty' => $qty,
                ]
            );
            $this->command->info('Creating...' . $sale->id);
        }
        cache()->flush();
    }
}
