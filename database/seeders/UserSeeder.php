<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate(
            [
                'email' =>   'demo@user.test',
            ],[
                'name' =>  'Demo User',
                'password' => Hash::make('1q2w3e++2023ABC'),
            ]
        );

        $this->command->info('Creating...' . $user->name);
    }
}
