<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;

class RouteHelper
{
    public static function addRoutes($controllerName, $functions, $routeFile = 'web')
    {
        $functions_with_keys = [];
        foreach ($functions as $functionFileName) {
            // إزالة الامتداد '.php' من اسم الملف
            $functionName = strtolower(str_replace('Function.php', '', $functionFileName));
            $functions_with_keys[$functionName] = [
                'method' => 'get', // يمكن تخصيص طريقة HTTP هنا
                'params' => '',    // يمكن تخصيص المعاملات هنا
            ];
        }
        $functions = $functions_with_keys;

        $urlPath = strtolower(str_replace('Controller','',$controllerName));
        $routeFilePath = base_path("routes/{$routeFile}.php");

        if (!File::exists($routeFilePath)) {
            throw new \Exception("The route file {$routeFile}.php does not exist.");
        }

        $routeContent = File::get($routeFilePath);
        $newRoutes = '';

        if (!is_array($functions) || empty($functions)) {
            throw new \Exception("Invalid or empty functions array provided.");
        }

        foreach ($functions as $functionName => $functionData) {
            if (!is_string($functionName)) {
                throw new \Exception("Invalid function name '{$functionName}' in controller '{$controllerName}'. Function name must be a string.");
            }

            if (!is_array($functionData) || !isset($functionData['method'])) {
                throw new \Exception("Invalid function data for function '{$functionName}' in controller '{$controllerName}'.");
            }

            $routeMethod = strtolower($functionData['method']);
            $routeParam = '';

            if (!empty($functionData['params'])) {
                $routeParam = '/{' . $functionData['params'] . '}';
            }

if($routeFile == 'web'){
            $newRoutes .= <<<EOD

Route::{$routeMethod}('/{$urlPath}/{$functionName}{$routeParam}', [App\Http\Controllers\controlPanal\\{$controllerName}::class, '{$functionName}'])->name('{$urlPath}.{$functionName}.{$routeFile}');
EOD;
}
else{
    $newRoutes .= <<<EOD

    Route::{$routeMethod}('/{$urlPath}/{$functionName}{$routeParam}', [App\Http\Controllers\Api\\{$controllerName}::class, '{$functionName}'])->name('{$urlPath}.{$functionName}.{$routeFile}');
    EOD;
}
        }

        $routeContent .= $newRoutes;
        File::put($routeFilePath, $routeContent);
    }
}
