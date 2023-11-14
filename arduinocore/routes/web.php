<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();


Route::middleware(['auth'])->group(function () {
    
    //usuarios
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //categories
    Route::get("categories", [App\Http\Controllers\CategoryController::class, "index"])->name("categories.index"); //categories
    Route::get("categories/get-data", [App\Http\Controllers\CategoryController::class, "getData"])->name("categories.data"); //categories
    Route::get("categories/create", [App\Http\Controllers\CategoryController::class, "create"])->name("categories.create"); //categories
    Route::get("categories/{id}", [App\Http\Controllers\CategoryController::class, "show"])->name("categories.show");    
    Route::post("categories", [App\Http\Controllers\CategoryController::class, "store"])->name("categories.store"); //categories
    Route::post("categories/edit", [App\Http\Controllers\CategoryController::class, "edit"])->name("categories.edit"); //categories
    Route::put("categories", [App\Http\Controllers\CategoryController::class, "update"])->name("categories.update"); //categories
    Route::delete("categories/{id}", [App\Http\Controllers\CategoryController::class, "destroy"])->name("categories.delete"); //categories

    //modules
    Route::get("modules", [App\Http\Controllers\ModuleController::class, "index"])->name("modules.index"); //modules
    Route::get("modules/get-data", [App\Http\Controllers\ModuleController::class, "getData"])->name("modules.data"); //modules
    Route::get("modules/create", [App\Http\Controllers\ModuleController::class, "create"])->name("modules.create"); //modules
    Route::get("modules/{id}", [App\Http\Controllers\ModuleController::class, "show"])->name("modules.show");    
    Route::post("modules", [App\Http\Controllers\ModuleController::class, "store"])->name("modules.store"); //modules
    Route::post("modules/edit", [App\Http\Controllers\ModuleController::class, "edit"])->name("modules.edit"); //modules
    Route::put("modules", [App\Http\Controllers\ModuleController::class, "update"])->name("modules.update"); //modules
    Route::delete("modules/{id}", [App\Http\Controllers\ModuleController::class, "destroy"])->name("modules.delete"); //modules

    //Profiles
    Route::get("profiles", [App\Http\Controllers\ProfileController::class, "index"])->name("profiles.index"); //profiles
    Route::get("profiles/get-data", [App\Http\Controllers\ProfileController::class, "getData"])->name("profiles.data"); //profiles
    Route::get("profiles/create", [App\Http\Controllers\ProfileController::class, "create"])->name("profiles.create"); //profiles
    Route::get("profiles/{id}", [App\Http\Controllers\ProfileController::class, "show"])->name("profiles.show");    
    Route::post("profiles", [App\Http\Controllers\ProfileController::class, "store"])->name("profiles.store"); //profiles
    Route::post("profiles/edit", [App\Http\Controllers\ProfileController::class, "edit"])->name("profiles.edit"); //profiles
    Route::put("profiles", [App\Http\Controllers\ProfileController::class, "update"])->name("profiles.update"); //profiles
    Route::delete("profiles/{id}", [App\Http\Controllers\ProfileController::class, "destroy"])->name("profiles.delete"); //profiles

    //permissions
    Route::get("permissions", [App\Http\Controllers\PermissionController::class, "index"])->name("permissions.index"); //permissions
    Route::get("permissions/get-data", [App\Http\Controllers\PermissionController::class, "getData"])->name("permissions.data"); //permissions
    Route::get("permissions/create", [App\Http\Controllers\PermissionController::class, "create"])->name("permissions.create"); //permissions
    Route::get("permissions/{id}", [App\Http\Controllers\PermissionController::class, "show"])->name("permissions.show");    
    Route::post("permissions", [App\Http\Controllers\PermissionController::class, "store"])->name("permissions.store"); //permissions
    Route::post("permissions/edit", [App\Http\Controllers\PermissionController::class, "edit"])->name("permissions.edit"); //permissions
    Route::put("permissions", [App\Http\Controllers\PermissionController::class, "update"])->name("permissions.update"); //permissions
    Route::delete("permissions/{id}", [App\Http\Controllers\PermissionController::class, "destroy"])->name("permissions.delete"); //profiles
    
    Route::get('usuarios', [App\Http\Controllers\UserController::class, 'index']);
    Route::get('get-usuarios', [App\Http\Controllers\UserController::class, 'getUsuarios']);
    Route::post('usuarios/create', [App\Http\Controllers\UserController::class, 'create']);
    Route::post('usuarios/edit', [App\Http\Controllers\UserController::class, 'edit']);
    Route::post('usuarios', [App\Http\Controllers\UserController::class, 'store']);
    Route::put('usuarios', [App\Http\Controllers\UserController::class, 'update']);
    Route::delete("usuarios/{id}", [App\Http\Controllers\UserController::class, "destroy"]);

    Route::post('upload', [App\Http\Controllers\UploadController::class, 'store']);
    Route::delete('upload', [App\Http\Controllers\UploadController::class, 'delete']);

    //Roles
    Route::post("roles", [App\Http\Controllers\RoleController::class, "store"])->name("roles.store"); //profiles
    
});

