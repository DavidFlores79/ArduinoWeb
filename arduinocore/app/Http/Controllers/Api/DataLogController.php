<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DataLogController extends Controller
{
    public function guardarDatos(Request $request)
    {   
        //return $request;
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
                'message' => 'Ocurrió un error al insertar los datos.',
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function getDatos() {
        $currentDateTime = Carbon::now();
        $newDateTime = Carbon::now()->subHours(5);
        $datos = DataLog::where('created_at', '>=', $newDateTime->toDateString())->orderBy('created_at', 'DESC')->get();

        if(is_object($datos)){
            $data = [
                'code' => 200,
                'status' => 'success',
                'total' => "Se han encontrado: ".count($datos)." resultados.",
                'datos' => $datos,
            ];
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Ocurrió un error al traer los datos.',
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function getFechaActual() {
        return Carbon::now()->format('Y-m-d H:i:m');
    }
}
