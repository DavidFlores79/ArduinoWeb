<?php

namespace App\Services;

use App\Traits\LogTrait;
use App\Traits\ProfileTrait;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Clase MenuService para la lógica del Módulo Home.
 */
class MenuService
{
  use LogTrait, ProfileTrait;

  /**
   * Obtiene todos los catalogos del modulo.
   *
   * @return \Illuminate\Http\Response
   * @throws \ErrorException si no existen registros para mostrar.
   */
  public function getMenu()
  {

    try {

      $modules = auth()->user()->profile->profile_modules;

      // Formar el nuevo array con todas las categorías y sus módulos correspondientes GPT
      $newArray = [];

      foreach ($modules as $module) {
        // foreach ($module['modulosap'] as $categoria) {
        $categoryId = $module['category']['id'];

        if (!isset($newArray[$categoryId])) {
          $newArray[$categoryId] = [
            'id' => $categoryId,
            'short_description' => $module['category']['short_description'],
            'long_description' => $module['category']['long_description'],
            'modules' => [],
          ];
        }

        $moduleId = $module['id'];

        // Verificar si el módulo ya ha sido agregado a la categoría
        $moduleAgregado = false;
        foreach ($newArray[$categoryId]['modules'] as $moduleExistente) {
          if ($moduleExistente['id'] === $moduleId) {
            $moduleAgregado = true;
            break;
          }
        }

        // Agregar el módulo solo si no ha sido agregado previamente
        if (!$moduleAgregado) {
          $newArray[$categoryId]['modules'][] = [
            'id' => $moduleId,
            'name' => $module['name'],
            'route' => $module['route'],
            'image' => $module['image'],
          ];
        }
        // }
      }

      // Reindexar el array para tener un array sin las claves numéricas de las categorías
      $newArray = array_values($newArray);

      $data = [
        "code" => 200,
        "status" => "success",
        "menu" => $newArray,
      ];

      // $this->saveEvent("PPC - Configuración", "ha obtenido los catálogos", "S/D"); //bitacora

      return response()->json($data, $data["code"]);
    } catch (\Exception $e) {
      if (str_contains($e->getMessage(), "Failed to connect") || str_contains($e->getMessage(), "Operation timed out")) throw new \ErrorException("Tiempo de espera agotado.", 500);
      $this->saveEvent("PPC - Home", "intentó obtener los catálogos", "S/D", false); //bitacora
      throw new HttpException(($e->getCode() > 500 || $e->getCode() < 100) ? 500 : $e->getCode(), $e->getMessage());
    }
  }
}
