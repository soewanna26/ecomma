<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserTableSeeder::class);
        $this->call(TblColorTableSeeder::class);
        $this->call(TblDistrictsTableSeeder::class);
        $this->call(TblDivisionsTableSeeder::class);
        $this->call(TblTownshipsTableSeeder::class);
        $this->call(TblSizeChartTableSeeder::class);
        $this->call(CountrySeeder::class);
        \App\Models\User::factory(5)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
