<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ControllerGeneratorService
{
    public function createController($controllerName, $functions)
    {
        $methods = '';
        $traits = '';

        // Generate the function files array
        foreach ($functions as $functionName => $methodNAme) {
            $fileName = Str::studly($functionName) . 'Function';
            $functionFiles[$functionName] = $fileName;
        }
        // Extract the model name from the controller name
        $modelName = str_replace('Controller', '', $controllerName);
        $modelNamePlural = Str::plural($modelName);
        $modelNameSmall = strtolower($modelName);
        // $modelNames=Str::plural($modelName);
// dd($functionFiles);
        // Extract traits and methods
        foreach ($functionFiles as $functionName => $fileName) {
            $traits .= "use \\App\\Functions\\{$fileName};\n";

            // Load the trait file content
            $traitPath = app_path("Functions/{$fileName}.php");
            if (file_exists($traitPath)) {
                $fileContent = file_get_contents($traitPath);

                // Extract method bodies from the trait file content
                preg_match_all('/(?:public|protected|private)\s+function\s+[a-zA-Z0-9_]+\s*\([^)]*\)\s*\{(?:[^{}]*|\{(?:[^{}]*|\{[^{}]*\})*\})*\}/s', $fileContent, $matches);
                foreach ($matches[0] as $method) {
                    $methodWithModel = str_replace('ModalName', $modelName, $method);
                    $methodWithModel = str_replace('modalName', $modelNameSmall, $methodWithModel);
                    $methodWithModel = str_replace('modalNames', $modelNamePlural, $methodWithModel);
    
                    $methods .=  $methodWithModel . "\n";


                }
            }
        }

        $controllerPath = app_path("Http/Controllers/{$controllerName}.php");

        // Generate the controller template
        $controllerTemplate = $this->generateControllerTemplate($controllerName, $traits, $methods, $modelName);

        // Save the controller file
        File::put($controllerPath, $controllerTemplate);

        // Add routes
        // $this->addRoutes($controllerName, $functions);

        return response()->json(['message' => 'Controller created successfully']);
    }

    private function generateControllerTemplate($controllerName, $traits, $methods, $modelName)
    {
                // Generate the model path
                $modelPath = "use App\\Models\\{$modelName};";

        return <<<EOD
<?php

namespace App\Http\Controllers;

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
