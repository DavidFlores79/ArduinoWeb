<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Permission;
use App\Models\Profile;
use App\Traits\ProfileTrait;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ProfileController extends Controller
{
    use ProfileTrait;

    public function index()
    {
        return view('admin.profiles.index');
    }

    public function getData()
    {
        try {
            $data = Profile::where("status", 1)->get();
            $modules = Module::where("status", 1)->get();
            $permissions = Permission::all();
            $codes = [
                ["id" => 1, "code" => "superuser", "name" => "Super Usuario",],
                ["id" => 2, "code" => "admin", "name" => "Administrador",],
                ["id" => 3, "code" => "user", "name" => "Usuario",],
            ];

            $this->getModulesandPermissions($data);

            if (!is_object($data)) {
                throw new \ErrorException("Error al obtener los catálogos.", 404);
            }

            $data = [
                "code" => 200,
                "status" => "success",
                "data" => $data,
                "codes" => $codes,
                "modules" => $modules,
                "permissions" => $permissions,
            ];

            // $this->saveEvent("Perfiles - Catálogos", "ha obtenido los catálogos", "S/D"); //bitacora

            return response()->json($data, $data["code"]);
        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), "Failed to connect") || str_contains($e->getMessage(), "Operation timed out")) throw new \ErrorException("Tiempo de espera agotado.", 500);
            // $this->saveEvent("Admon Usuarios - Catálogos", "intentó obtener los catálogos", "S/D", false); //bitacora
            throw new HttpException(($e->getCode() > 500 || $e->getCode() < 100) ? 500 : $e->getCode(), $e->getMessage());
        }
    }

    public function create()
    {
        $data = [
            'code' => 200,
            'status' => 'success',
        ];
        return response()->json($data, $data['code']);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'code' => 'required|in:1, 2, 3',
            'description' => 'nullable|string|max:255',
        ];
        $this->validate($request, $rules);

        try {
            $item = new Profile();
            $item->name = $request->input('name');
            $item->code = $request->input('code');
            $item->description = $request->input('description');
            $item->status = 1;
            $item->save();

            if (is_object($item)) {
                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Item creado satisfactoriamente',
                    'item' => $item,
                ];
            }

            // $this->saveEvent("Perfiles - Crear", "ha creado el registro $item->id con nombre $item->name", "S/D"); //bitacora

            return response()->json($data, $data['code']);
        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), "Failed to connect") || str_contains($e->getMessage(), "Operation timed out")) throw new \ErrorException("Tiempo de espera agotado.", 500);
            // $this->saveEvent("Admon Usuarios - Catálogos", "intentó obtener los catálogos", "S/D", false); //bitacora
            throw new HttpException(($e->getCode() > 500 || $e->getCode() < 100) ? 500 : $e->getCode(), $e->getMessage());
        }
    }

    public function edit()
    {
        $data = [
            'code' => 200,
            'status' => 'success',
        ];
        return response()->json($data, $data['code']);
    }

    public function update(Request $request)
    {
        //falta validar request
        $rules = [
            'id' => 'required|exists:profiles,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|in:1, 2, 3',
            'description' => 'nullable|string|max:255',
        ];
        $this->validate($request, $rules);

        if ($request->input('id'))
            $item = Profile::where('id', $request->input('id'))->first();

        try {
            if (is_object($item)) {

                $item->name = $request->input('name');
                $item->description = $request->input('description');
                $item->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Item actualizado.',
                    'item' => $item,
                ];

                // $this->saveEvent("Perfiles - Editar", "ha editado el registro $item->id con nombre $item->name", "S/D"); //bitacora
                return response()->json($data, $data['code']);
            }
        } catch (\Throwable $th) {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'Error al actualizar.' . $th,
            ];
            return response()->json($data, $data['code']);
        }
    }

    public function destroy($id)
    {
        $item = Profile::where('id', $id)->first();

        if (is_object($item)) {
            $item->delete();
            $data = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Item eliminado.',
                'item' => $item,
            ];
            // $this->saveEvent("Perfiles - Eliminar", "ha eliminado el registro $item->id con nombre $item->name", "S/D"); //bitacora
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'No se encontró el item.',
            ];
        }
        return response()->json($data, $data['code']);
    }

}
