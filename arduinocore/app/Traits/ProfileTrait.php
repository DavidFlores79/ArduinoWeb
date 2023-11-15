<?php

namespace App\Traits;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Auth;

trait ProfileTrait
{
    public function getModulesandPermissions($profiles)
    {
        foreach ($profiles as $key => $profile) {
            $permission = array();
            foreach ($profile->permissions as $permissionsModule) {
                $moduleId = $permissionsModule->pivot->module_id;
                $permissionId = $permissionsModule->pivot->permission_id;
                $permission[$moduleId][] = "$permissionId";
            }
            $profile->permissionIds = $permission;

            // Decodificar el JSON a un array de PHP
            $data = json_decode($profile->profile_modules, true);
            // Obtener solo los nombres sin repeticiones
            $uniqueNames = array_unique(array_column($data, 'name'));
            $profile->modules_related = $uniqueNames;
        }
    }

    public function getProfileModulesandPermissions($profile)
    {
        $permission = array();
        foreach ($profile->permissions as $permissionsModule) {
            $moduleId = $permissionsModule->pivot->module_id;
            $permissionId = $permissionsModule->pivot->permission_id;
            $permission[$moduleId][] = "$permissionId";
        }
        $profile->permissionIds = $permission;

        // Decodificar el JSON a un array de PHP
        $data = json_decode($profile->profile_modules, true);
        // Obtener solo los nombres sin repeticiones
        $uniqueNames = array_unique(array_column($data, 'name'));
        $profile->modules_related = $uniqueNames;

        return $profile;
    }

    public function getMenu()
    {

        try {

            $modules =  Auth::user()->profile->profile_modules;

            // Formar el nuevo array con todas las categorías y sus módulos correspondientes GPT
            $menuData = [];

            foreach ($modules as $module) {
                // foreach ($module['modulosap'] as $categoria) {
                $categoryId = $module['category']['id'];

                if (!isset($menuData[$categoryId])) {
                    $menuData[$categoryId] = [
                        'id' => $categoryId,
                        'short_description' => $module['category']['short_description'],
                        'long_description' => $module['category']['long_description'],
                        'modules' => [],
                    ];
                }

                $moduleId = $module['id'];

                // Verificar si el módulo ya ha sido agregado a la categoría
                $moduleAgregado = false;
                foreach ($menuData[$categoryId]['modules'] as $moduleExistente) {
                    if ($moduleExistente['id'] === $moduleId) {
                        $moduleAgregado = true;
                        break;
                    }
                }

                // Agregar el módulo solo si no ha sido agregado previamente
                if (!$moduleAgregado) {
                    $menuData[$categoryId]['modules'][] = [
                        'id' => $moduleId,
                        'name' => $module['name'],
                        'route' => $module['route'],
                        'image' => $module['image'],
                    ];
                }
                // }
            }

            // Reindexar el array para tener un array sin las claves numéricas de las categorías
            $menuData = array_values($menuData);

            $data = [
                "code" => 200,
                "status" => "success",
                "menu" => $menuData,
            ];

            // $this->saveEvent("PPC - Configuración", "ha obtenido los catálogos", "S/D"); //bitacora

            return response()->json($data, $data["code"]);
        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), "Failed to connect") || str_contains($e->getMessage(), "Operation timed out")) throw new \ErrorException("Tiempo de espera agotado.", 500);
            $this->saveEvent("PPC - Home", "intentó obtener los catálogos", "S/D", false); //bitacora
            throw new HttpException(($e->getCode() > 500 || $e->getCode() < 100) ? 500 : $e->getCode(), $e->getMessage());
        }
    }
}
