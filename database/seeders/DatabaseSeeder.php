<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(CitySeeder::class);
        $this->call(TownSeeder::class);
    }
}
