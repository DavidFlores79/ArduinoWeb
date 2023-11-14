<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profiles = [
            ['code' => 'superuser', 'name' => 'Super Usuario'],
            ['code' => 'admin', 'name' => 'Administrador'],
            ['code' => 'user', 'name' => 'Usuario'],
        ];
        foreach ($profiles as $profile) {
            Profile::create([
                'code' => $profile['code'],
                'name' => $profile['name'],
            ]);
        }
    }
}
