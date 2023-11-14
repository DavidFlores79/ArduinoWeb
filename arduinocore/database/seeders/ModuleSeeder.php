<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = [
            ['name' => 'Perfiles', 'description' => 'CRUD de Perfiles', 'route' => 'profiles', 'category_id' => 1],
            ['name' => 'Usuarios', 'description' => 'CRUD de Usuarios', 'route' => 'users', 'category_id' => 1],
            ['name' => 'Modulos', 'description' => 'CRUD de Modulos', 'route' => 'modules', 'category_id' => 1],
            ['name' => 'Categorías', 'description' => 'CRUD de Categorías', 'route' => 'categories', 'category_id' => 1],
        ];
        foreach ($modules as $module) {
            Module::create([
                'name' => $module['name'],
                'description' => $module['description'],
                'route' => $module['route'],
                'category_id' => $module['category_id'],
            ]);
        }
    }
}


// {
//     "name": "Usuarios",
//     "description": "CRUD de usuarios",
//     "route": "users",
//     "category_id": "1",
//     "status": true,
//     "id": 1,
//     "category": {
//         "id": 1,
//         "short_description": "Módulos Administrativos",
//         "long_description": "Donde se muestran los CRUDs",
//         "icon": null,
//         "enabled": 1,
//         "status": 1,
//         "created_at": "2023-11-13T18:50:10.000000Z",
//         "updated_at": "2023-11-13T18:50:10.000000Z"
//     }
// }