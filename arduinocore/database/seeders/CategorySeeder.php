<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profiles = [
            ['short_description' => 'Módulos Administrativos', 'long_description' => 'Donde se muestran los CRUDs'],
            ['short_description' => 'Sensores y Dispositivos', 'long_description' => 'Se dan de alta dispositivos y/o sensores para cargar información.'],
        ];
        foreach ($profiles as $profile) {
            Category::create([
                'short_description' => $profile['short_description'],
                'long_description' => $profile['long_description'],
            ]);
        }
    }
}
