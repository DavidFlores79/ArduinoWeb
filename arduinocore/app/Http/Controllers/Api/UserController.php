<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request) {
        //C1 2F D6 0E
        //E2 6F 6A 45

        $uid = $request->input('uid');
        $user = User::where('uid', $uid)->first();


        if(is_object($user)){
            $data = [
                'code' => 200,
                'status' => 'success',
                'success' => true,
                'message' => 'Usuario permitido',
                'user' => $user
            ];
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'success' => false,
                'message' => 'Usuario bloqueado. UID desconocido.',
            ];
        }

        return response()->json($data, $data['code']);

    }
}