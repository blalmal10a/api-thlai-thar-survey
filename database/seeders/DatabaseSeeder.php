<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        //seed super user
        $su = User::create([
            'name' => 'Super User',
            'email' => 'admin@example.email',
            'password' => bcrypt('admin@example.email')
        ]);

        $this->call([
            ShieldSeeder::class,
            DistrictSeeder::class,
            MeasurementUnitSeeder::class,
            UserSeeder::class,
            VegetableSeeder::class,
        ]);
    }
}
