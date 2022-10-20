<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataLog;
use Illuminate\Http\Request;

class DataLogController extends Controller
{
    public function guardarDatos(Request $request)
    {
        //validar el request
        $rules = [
            'sensor' => 'nullable|string|max:255',
            'temperatura' => 'required|numeric',
            'humedad' => 'required|numeric',
        ];
        $this->validate($request, $rules);

        $temp = new DataLog();
        $temp->temperatura = $request->input('temperatura');
        if ($request->input('sensor')) $temp->sensor = $request->input('sensor');
        if ($request->input('humedad')) $temp->humedad = $request->input('humedad');
        $temp->save();

        if(is_object($temp)){
            $data = [
                'code' => 200,
                'status' => 'success',
                'sensores' => $temp,
            ];
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Ocurrió un error al realizar la búsqueda.',
            ];
        }

        return response()->json($data, $data['code']);
    }
}
