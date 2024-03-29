<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'davidflorescastillo@gmail.com',
            'password' => bcrypt('Admin123'), // admin123
            'profile_id' => 2,
        ]);

        User::create([
            'name' => 'Emilio Carlo',
            'email' => 'emilio@enlacetecnologias.mx',
            'password' => bcrypt('Admin123'), // admin123
            'profile_id' => 3,
        ]);
    }
}
