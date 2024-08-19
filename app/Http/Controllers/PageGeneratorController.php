<?php

namespace App\Http\Controllers;

use App\Services\ModelService;
use App\Services\BladeControllerGeneratorService;
use App\Services\APIControllerGeneratorService;
use App\Services\MigrationService;
use App\Services\ViewGeneratorService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Helpers\RouteHelper;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use ReflectionClass;

class PageGeneratorController extends Controller
{
    protected $ModelService;
    protected $BladeControllerGeneratorService;
    protected $APIControllerGeneratorService;
    protected $MigrationService;
    protected $ViewGeneratorService;

    public function __construct(
        ModelService $ModelService,
        BladeControllerGeneratorService $BladeControllerGeneratorService,
        APIControllerGeneratorService $APIControllerGeneratorService,
        MigrationService $MigrationService,
        ViewGeneratorService $ViewGeneratorService
    ) {
        $this->ModelService = $ModelService;
        $this->BladeControllerGeneratorService = $BladeControllerGeneratorService;
        $this->APIControllerGeneratorService = $APIControllerGeneratorService;
        $this->MigrationService = $MigrationService;
        $this->ViewGeneratorService = $ViewGeneratorService;
    }

    public function createPage(Request $request)
    {





        // Validate the request
        // $request->validate([
        //     'table_name' => 'required|string|max:255',
        //     'columns' => 'required|array',
        //     'controller_name' => 'required|string|max:255',
        //     'functions' => 'required|array'
        // ]);


        $tableName = $request->input('table_name');
        $columns = $request->input('columns');
        $controllerName = ucfirst(Str::camel($tableName)) . 'Controller';
        $relations = $request->input('relations');  // table_name , foreign_key , table_rel
        $functions_blade = $request->input('functions_blade', []);
        $functions_api = $request->input('functions_api', []);
        $type_routes = $request->input('type_route', []); // Array containing 'web', 'api', or both

        // $relations[0]['table_refrence'] = 'test267s';
        // $relations[0]['foreign_key'] = 'company_id';
        // $relations[0]['relation_name'] = 'one_to_many';
        
        // Generate Migration
        $this->MigrationService->generateMigrationContent($tableName, $columns, $relations);

        // Extract column names from the columns array
        $namescolumns = array_column($columns, 'name');
        $this->ModelService->createModel($tableName, $namescolumns, $relations);

        // Generate Controllers and Routes based on type_route
        if (in_array('web', $type_routes)) {
            if (!empty($functions_blade) && is_array($functions_blade)) {
                $this->BladeControllerGeneratorService->createBladeController($controllerName, $functions_blade);
        RouteHelper::addRoutes($controllerName, $functions_blade, 'web');
            } else {
                // Handle the case where functions_blade is not valid
                return response()->json(['error' => 'Invalid functions_blade data'], 400);
            }
        }

        if (in_array('api', $type_routes)) {
            if (!empty($functions_api) && is_array($functions_api)) {
                $this->APIControllerGeneratorService->createAPIController($controllerName, $functions_api);
                RouteHelper::addRoutes($controllerName, $functions_api, 'api');
            } else {
                // Handle the case where functions_api is not valid
                return response()->json(['error' => 'Invalid functions_api data'], 400);
            }
        }

        // Generate Views
        $this->ViewGeneratorService->createViews($tableName, $columns, $request->input('views'));

        Artisan::call('route:cache');

        return response()->json(['message' => 'Page created successfully!']);
    }

    public function index()
    {
        $migrations = DB::table('migrations')->get();
        return view('admin.migration-maker.index', compact('migrations'));
    }

    public function create()
    {
        $migrations = DB::table('migrations')->get();
        $migrations_name = [];
        foreach($migrations as $migration){
            $migrations_name[] = substr_replace(substr_replace($migration->migration, '', 0, 25),'',-6);
        }

        $functionFiles = scandir(app_path('Functions'));
        $functions = [];
        foreach ($functionFiles as $file) {
            if (preg_match('/Function\.php$/', $file)) {
                $functionName = Str::camel(str_replace('Function.php', '', $file));
                $className = basename($file, '.php');
                $functions[$functionName] = $file;
            }


        }

        $views = ['create', 'index', 'edit'];
        return view('admin.migration-maker.create', compact('migrations_name', 'functions', 'views'));
    }
}
