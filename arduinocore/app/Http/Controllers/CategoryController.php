<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index');
    }

    public function getData()
    {
        $data = Category::where('status', true)->get();

        try {
            // $data = Category::where("status", 1)->get();
            $data = Category::all();

            if (!is_object($data)) {
                throw new \ErrorException("Error al obtener los catálogos.", 404);
            }

            $data = [
                "code" => 200,
                "status" => "success",
                "data" => $data,
            ];

            // $this->saveEvent("Perfiles - Catálogos", "ha obtenido los catálogos", "S/D"); //bitacora

            return response()->json($data, $data["code"]);
        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), "Failed to connect") || str_contains($e->getMessage(), "Operation timed out")) throw new \ErrorException("Tiempo de espera agotado.", 500);
            // $this->guardarEvento("Admon Usuarios - Catálogos", "intentó obtener los catálogos", "S/D", false); //bitacora
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
            'short_description' => 'required|string|max:255',
            'long_description' => 'nullable|string|max:255',
            'enabled' => 'nullable|boolean',
        ];
        $this->validate($request, $rules);

        try {
            $item = new Category();
            $item->short_description = $request->input('short_description');
            $item->long_description = $request->input('long_description');
            $item->enabled = ($request->input('enabled')) ? 1:0;
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
            // $this->guardarEvento("Admon Usuarios - Catálogos", "intentó obtener los catálogos", "S/D", false); //bitacora
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
            'id' => 'required|exists:categories,id',
            'short_description' => 'required|string|max:255',
            'long_description' => 'nullable|string|max:255',
            'enabled' => 'nullable|boolean',
        ];
        $this->validate($request, $rules);

        if ($request->input('id'))
            $item = Category::where('id', $request->input('id'))->first();

        try {
            if (is_object($item)) {

                $item->short_description = $request->input('short_description');
                $item->long_description = $request->input('long_description');
                $item->enabled = $request->input('enabled');
                if($request->input('status')) $item->status = $request->input('status');
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
        $item = Category::where('id', $id)->first();

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
