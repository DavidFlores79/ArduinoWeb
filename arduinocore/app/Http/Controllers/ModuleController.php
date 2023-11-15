<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Module;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use File;

class ModuleController extends Controller
{
    public function index()
    {
        return view('admin.modules.index');
    }

    public function getData()
    {
        $data = Module::where('status', true)->get();
        $categories = Category::where("enabled", 1)->get();
        
        try {
            // $data = Module::where("status", 1)->get();
            $data = Module::all();

            if (!is_object($data)) {
                throw new \ErrorException("Error al obtener los catálogos.", 404);
            }

            if (count($categories) <= 0) {
                throw new \ErrorException("No existen categorías para crear los módulos. Crea al menos una Categoría", 404);
            }

            $data = [
                "code" => 200,
                "status" => "success",
                "data" => $data->load('category'),
                "categories" => $categories,
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
            'description' => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'nullable|boolean',
            'image' => 'nullable|string|max:255',
        ];
        $this->validate($request, $rules);

        try {
            
            $item = new Module();
            if ($request->input("image") != "") {
                list($folder, $fileName) = explode("/", $request->image);
                File::move(("images/tmp/" . $folder . "/" . $fileName), ("images/modules/" . $fileName));
                $item->image = $fileName;
            }
            $item->name = $request->input("name");
            $item->description = $request->input("description");
            $item->route = $request->input("route");
            $item->category_id = $request->input("category_id");
            $item->status = ($request->input("status")) ? 1 : 0;
            $item->save();

            if (is_object($item)) {
                $data = [
                    "code" => 200,
                    "status" => "success",
                    "message" => "Item creado satisfactoriamente",
                    "item" => $item->load("category"),
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
            'id' => 'required|exists:modules,id',
            'description' => 'nullable|string|max:255',
            'route' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|boolean',
            'image' => 'nullable|string|max:255',
        ];
        $this->validate($request, $rules);

        if ($request->input('id'))
            $item = Module::where('id', $request->input('id'))->first();

        try {
            if (is_object($item)) {
                if ($request->input("image") != "" && ($item->image != $request->input("image")) ) {
                    list($folder, $fileName) = explode("/", $request->image);
                    File::move(("images/tmp/" . $folder . "/" . $fileName), ("images/modules/" . $fileName));
                    $item->image = $fileName;
                }
                if($request->input("image") == "") $item->image = '';
                $item->name = $request->input('name');
                $item->description = $request->input('description');
                $item->route = $request->input('route');
                $item->category_id = $request->input('category_id');
                $item->status = ($request->input('status')) ? 1 : 0;
                $item->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Item actualizado.',
                    'item' => $item->load('category'),
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
        $item = Module::where('id', $id)->first();

        if (is_object($item)) {
            $item->delete();
            $data = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Item eliminado.',
                'item' => $item->load('category'),
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
