<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProfileSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ModuleSeeder::class);
    }
}
