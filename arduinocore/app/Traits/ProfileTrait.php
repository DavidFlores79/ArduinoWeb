<?php

namespace App\Traits;

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
}
