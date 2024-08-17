<?php
// app/Services/ApiExportService.php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Route;

class ApiExportService
{
    public function exportApiRoutes()
    {
        // إنشاء كائن Spreadsheet جديد
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('API Routes');

        // إعداد العناوين
        $sheet->setCellValue('A1', 'Method');
        $sheet->setCellValue('B1', 'URI');
        $sheet->setCellValue('C1', 'Name');
        $sheet->setCellValue('D1', 'Action');

        // الحصول على جميع مسارات API من ملف routes/api.php
        $routes = Route::getRoutes();
        $row = 2;

        foreach ($routes as $route) {
            if (strpos($route->uri(), 'api/') === 0) { // تأكد من أنها مسارات API
                $methods = implode(',', $route->methods()); // طرق HTTP
                $uri = $route->uri(); // URI
                $name = $route->getName(); // اسم
                $action = isset($route->getAction()['controller']) ? $route->getAction()['controller'] : 'N/A'; // العمل

                $sheet->setCellValue('A' . $row, $methods);
                $sheet->setCellValue('B' . $row, $uri);
                $sheet->setCellValue('C' . $row, $name);
                $sheet->setCellValue('D' . $row, $action);
                $row++;
            }
        }

        // كتابة الملف
        $writer = new Xlsx($spreadsheet);
        $filePath = storage_path('app/public/api_routes.xlsx');
        $writer->save($filePath);

        return $filePath;
    }
}
