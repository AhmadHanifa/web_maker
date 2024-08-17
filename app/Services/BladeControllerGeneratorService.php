<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BladeControllerGeneratorService
{
    public function createBladeController($controllerName, $functions_blade)
    {
        $methods = '';
        $traits = '';
        $functionFiles = [];

        if (is_array($functions_blade)) {
            foreach ($functions_blade as $functionFileName) {
                // إزالة امتداد 'Function.php' وتحويل اسم الدالة إلى StudlyCase
                $functionName = Str::studly(str_replace('Function.php', '', $functionFileName));
                $functionFiles[$functionName] = $functionName;
            }
        }

        $modelName = str_replace('Controller', '', $controllerName);
        $modelNamePlural = Str::plural($modelName);
        $modelNameSmall = strtolower($modelName);

        foreach ($functionFiles as $functionName) {
            $traits .= "use \\App\\Functions\\{$functionName}Function;\n";

            $traitPath = app_path("Functions/{$functionName}Function.php");
            if (file_exists($traitPath)) {
                $fileContent = file_get_contents($traitPath);

                preg_match_all('/(?:public|protected|private)\s+function\s+[a-zA-Z0-9_]+\s*\([^)]*\)\s*\{(?:[^{}]*|\{(?:[^{}]*|\{[^{}]*\})*\})*\}/s', $fileContent, $matches);
                foreach ($matches[0] as $method) {
                    $methodWithModel = str_replace('ModalName', $modelName, $method);
                    $methodWithModel = str_replace('modalName', $modelNameSmall, $methodWithModel);
                    $methodWithModel = str_replace('modalNames', $modelNamePlural, $methodWithModel);
    
                    $methods .=  $methodWithModel . "\n";


                }
            }
        }

        $controllerPath = app_path("Http/Controllers/controlPanal/{$controllerName}.php");

        // Ensure the directory exists before writing the file
        if (!File::isDirectory(dirname($controllerPath))) {
            File::makeDirectory(dirname($controllerPath), 0755, true);
        }

        $controllerTemplate = $this->generateBladeControllerTemplate($controllerName, $traits, $methods, $modelName);

        File::put($controllerPath, $controllerTemplate);

        return response()->json(['message' => 'Blade Controller created successfully']);
    }

    private function generateBladeControllerTemplate($controllerName, $traits, $methods, $modelName)
    {
        $modelPath = "use App\\Models\\{$modelName};";

        return <<<EOD
<?php

namespace App\Http\Controllers\controlPanal;

use App\Http\Controllers\Controller;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
{$traits}
{$modelPath}

class {$controllerName} extends Controller
{
    {$methods}
}
EOD;
    }
}
