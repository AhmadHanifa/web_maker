<?php

namespace App\Http\Controllers\controlPanal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Functions\CreateFunction;
use \App\Functions\IndexFunction;
use \App\Functions\StoreFunction;
use App\Services\ApiExportService;
use Illuminate\Support\Facades\Response;

use App\Models\Exelexport;

class ExelexportController extends Controller
{

    
        protected $apiExportService;
    
        public function __construct(ApiExportService $apiExportService)
        {
            $this->apiExportService = $apiExportService;
        }
    
        public function downloadApiRoutes()
        {
            $filePath = $this->apiExportService->exportApiRoutes();
    
            // تقديم الملف للتنزيل
            return Response::download($filePath)->deleteFileAfterSend(true);
        }


    public function create()
    {
        $exelexports= Exelexport::get();
        $filePath = $this->apiExportService->exportApiRoutes();
    
        // تقديم الملف للتنزيل
        return Response::download($filePath)->deleteFileAfterSend(true);
    }

   
public function index()
    {

        $exelexports= Exelexport::get();
        return view('exelexport.index',compact('exelexports'));

}
public function store(Request $request)
    {

        $newItem = $request->all();
        Exelexport::create($newItem);
  
        return redirect(route('exelexport.index'));
     
    }

}