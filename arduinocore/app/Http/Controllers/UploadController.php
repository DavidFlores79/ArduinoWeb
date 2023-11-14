<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'avatar' => 'mimes:jpg,png,jpeg,gif,svg|max:4096|dimensions:min_width=50,min_height=50',
        ];
        $this->validate($request, $rules);

        File::deleteDirectory('images/tmp/');//Borrado de archivos basura

        if ($request->hasFile('avatar')) {

            $direccion = "images/tmp";
            if (!is_dir($direccion)) {
                //mkdir($direccion, 0777, true);
                File::makeDirectory($direccion);
            }

            $file = $request->file('avatar');
            $fileName = $file->getClientOriginalName();
            $folder = uniqid() . '-' . now()->timestamp;
            $destinationPath = "images/tmp/" . $folder;
            File::makeDirectory("images/tmp/" . $folder);

            move_uploaded_file($request->file('avatar'), $destinationPath . "/" . $fileName);
            return $folder . '/' . $fileName;
        }

    }

    public function delete(Request $request) {
        return $request->all();
    }

    // public function uploadPdf(Request $request)
    // {
    //     // $rules = [
    //     //     'archivo' => 'mimes:application/pdf|max:5000',
    //     // ];
    //     // $this->validate($request, $rules);

    //     //File::deleteDirectory('archivos/tmp/'); //Borrado de archivos basura

    //     if ($request->hasFile('archivo')) {

    //         $direccion = "archivos/tmp";
    //         if (!is_dir($direccion)) {
    //             File::makeDirectory($direccion, 0777, true, true);
    //         }

    //         $file = $request->file('archivo');
    //         $fileName = $file->getClientOriginalName();
    //         $finalFile = now()->timestamp . '-' . $fileName;
    //         $destinationPath = "archivos/tmp/";
    //         // File::makeDirectory("images/tmp/");

    //         move_uploaded_file($request->file('archivo'), $destinationPath . $finalFile);
    //         return $finalFile;
    //     }

    // }

    // public function uploadNOM(Request $request)
    // {

    //     // $rules = [
    //     //     'archivo' => 'mimes:application/pdf|max:5000',
    //     // ];
    //     // $this->validate($request, $rules);

    //     if ($request->hasFile('archivo050')) {

    //         $direccion = "archivos/tmp";
    //         if (!is_dir($direccion)) {
    //             File::makeDirectory($direccion, 0777, true, true);
    //         }

    //         $file = $request->file('archivo050');
    //         $fileName = $file->getClientOriginalName();
    //         $finalFile = now()->timestamp . '-' . $fileName;
    //         $destinationPath = "archivos/tmp/";
    //         // File::makeDirectory("images/tmp/");

    //         move_uploaded_file($request->file('archivo050'), $destinationPath . $finalFile);
    //         return $finalFile;
    //     }

    //     if ($request->hasFile('archivo051')) {

    //         $direccion = "archivos/tmp";
    //         if (!is_dir($direccion)) {
    //             File::makeDirectory($direccion, 0777, true, true);
    //         }

    //         $file = $request->file('archivo051');
    //         $fileName = $file->getClientOriginalName();
    //         $finalFile = now()->timestamp . '-' . $fileName;
    //         $destinationPath = "archivos/tmp/";
    //         // File::makeDirectory("images/tmp/");

    //         move_uploaded_file($request->file('archivo051'), $destinationPath . $finalFile);
    //         return $finalFile;
    //     }

    // }

    // public function destroy(Request $request)
    // {

    // }
}
