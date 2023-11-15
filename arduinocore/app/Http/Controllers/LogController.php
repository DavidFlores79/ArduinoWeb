<?php

namespace App\Http\Controllers;

use App\Models\Log;
use DateTime;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        return view("admin.logs.index");
    }
    public function getData()
    {
        $dt = new DateTime();
        $logs = Log::whereDate('created_at', '=', $dt->format("Ymd"))->orderBy('created_at', 'desc')->get();
        $data = [
            'code' => 200,
            'status' => 'success',
            'logs' => $logs,
        ];
        return response()->json($data, $data['code']);
    }

    public function updateLog(Request $request)
    {
        $rules = [
            'log_date' => 'required|date',
        ];
        $this->validate($request, $rules);

        $dt = new DateTime();
        $log_date = $request->log_date;
        $timestamp = strtotime($log_date);
        $newDate = date("Y-m-d", $timestamp);
        $logs = Log::whereDate('created_at', '=', $newDate)->orderBy('created_at', 'desc')->get();
        if (is_object($logs)) {
            $data = [
                'code' => 200,
                'status' => 'success',
                'logs' => $logs,
            ];
        } else {
            $data = [
                'code' => 404,
                'message' => 'Error al actualizar la Bitacora.',
                'status' => 'error',
            ];
        }
        return response()->json($data, $data['code']);
    }
}
