<?php

namespace App\Http\Controllers\controlPanal;

use App\Http\Controllers\Controller;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use \App\Functions\CreateFunction;
use \App\Functions\EditFunction;
use \App\Functions\IndexFunction;
use \App\Functions\ShowFunction;
use \App\Functions\StoreFunction;
use \App\Functions\UpdateFunction;

use App\Models\Imagetest3;

class Imagetest3Controller extends Controller
{
    public function create()
    {
        return view('imagetest3.create');
    }
public function edit($id)
    {
        $imagetest3 = Imagetest3::findOrFail($id);
        return view('imagetest3.edit',compact('imagetest3'));
    }
public function index()
    {

        $imagetest3s= Imagetest3::get();
        return view('imagetest3.index',compact('imagetest3s'));

}
public function show($id)
    {
        // function body here
    }
public function store(Request $request)
    {
        $newItem = $request->all();

        // احصل على جميع الملفات من الطلب
        $files = $request->allFiles();
        
        // حلقة عبر الملفات لمعرفة ما إذا كانت صورة
        foreach ($files as $key => $file) {
            // التحقق مما إذا كان الملف صورة
            if ($file->isValid() && in_array($file->extension(), ['jpeg', 'png', 'jpg', 'gif', 'svg','webp'])) {
                // استخدم الهيلبر لتحميل الصورة والحصول على مسارها
                $newItem[$key] = ImageHelper::handleImageUpload($file, 'uploads/Imagetest3_images');
            }
        }
        
        // إنشاء العنصر الجديد في قاعدة البيانات
        Imagetest3::create($newItem);
        
        // إعادة التوجيه إلى صفحة العرض
        return redirect(route('imagetest3.index.web'));
        
    }

}