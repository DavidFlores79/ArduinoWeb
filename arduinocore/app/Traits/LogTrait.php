<?php

namespace App\Traits;

use App\Models\Log;
use DateTime;
use Illuminate\Support\Facades\Auth;

trait LogTrait
{
    public function saveEvent($description, $trace = "", $document = "S/D", $success = true)
    {
        $dt = new DateTime();
        $bitacora = new Log();
        $bitacora->document = $document;
        $bitacora->ip_address = $this->getIpAddress();
        $bitacora->nickname_name = Auth::user()->nickname." - ".Auth::user()->name;
        $bitacora->description = $description;
        $bitacora->trace = "El usuario: ".$bitacora->nickname_name." ".$trace." Fecha: ".$dt->format('Y-m-d H:i:s');
        $bitacora->success = $success;
        $bitacora->save();
        return $bitacora;
    }

    public function saveEventApi($user, $description, $trace = "", $document = "S/D", $success = true)
    {
        $dt = new DateTime();
        $bitacora = new Log();
        $bitacora->ip_address = $this->getIpAddress();
        $bitacora->nickname_name = $user->nickname." - ".$user->name;
        $bitacora->description = $description;
        $bitacora->document = $document;
        $bitacora->trace = "El usuario: ".$bitacora->nickname_name." ".$trace." Fecha: ".$dt->format('Y-m-d H:i:s');
        $bitacora->success = $success;
        $bitacora->save();
        return $bitacora;
    }

    public function saveEventCronJob($description, $trace = "", $document = "S/D", $success = true)
    {
        $dt = new DateTime();
        $bitacora = new Log();
        $bitacora->document = $document;
        $bitacora->ip_address = $this->getIpAddress();
        $bitacora->nickname_name = env('APP_NAME', 'TaskScheduling Server');
        $bitacora->description = $description;
        $bitacora->trace = $bitacora->nickname_name." ".$trace." Fecha: ".$dt->format('Y-m-d H:i:s');
        $bitacora->success = $success;
        $bitacora->save();
        return $bitacora;
    }

    public function getIpAddress()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';    
        return $ipaddress; 
    }
}