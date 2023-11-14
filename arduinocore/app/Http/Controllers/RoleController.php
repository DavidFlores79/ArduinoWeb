<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Profile;
use App\Traits\ProfileTrait;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use ProfileTrait;

    public function store(Request $request)
    {
        /** validamos el request */
        $rules = [
            'profile_id' => 'required|exists:profiles,id',
            'module_permissions' => 'required|array',
        ];
        $this->validate($request, $rules);

        $permissions_selected = $request->module_permissions;
        $profile = Profile::findOrFail($request->input('profile_id'));
        $permissions = array();
        $syncData = array();

        for ($i = 1; $i <= Module::count(); $i++) {
            if (isset($permissions_selected[$i])) {
                $permissions[] = count($permissions_selected[$i]);
                for ($j = 0; $j < count($permissions_selected[$i]); $j++) {
                    $syncData[] = ['module_id' => $i, 'permission_id' => $permissions_selected[$i][$j]];
                }
            }
        }
        // return $syncData;
        $profile->permissions()->detach();
        $profile->permissions()->sync($syncData);
        $profile = $this->getProfileModulesandPermissions($profile);

        $data = [
            'code' => 200,
            'message' => 'Los permisos en los módulos se han guardado correctamente.',
            'status' => 'success',
            'item' => $profile,
        ];

        return response()->json($data, $data['code']);
    }

}
