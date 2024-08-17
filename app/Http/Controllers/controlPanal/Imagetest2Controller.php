<?php

namespace App\Http\Controllers\controlPanal;

use App\Http\Controllers\Controller;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use \App\Functions\CreateFunction;
use \App\Functions\EditFunction;
use \App\Functions\IndexFunction;
use \App\Functions\StoreFunction;
use \App\Functions\UpdateFunction;

use App\Models\Imagetest2;

class Imagetest2Controller extends Controller
{
    public function create()
    {
        return view('imagetest2.create');
    }
public function edit($id)
    {
        $imagetest2 = Imagetest2::findOrFail($id);
        return view('imagetest2.edit',compact('imagetest2'));
    }
public function index()
    {

        $imagetest2s= Imagetest2::get();
        return view('imagetest2.index',compact('imagetest2s'));

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
                $newItem[$key] = ImageHelper::handleImageUpload($file, 'uploads/Imagetest2_images');
            }
        }
        
        // إنشاء العنصر الجديد في قاعدة البيانات
        Imagetest2::create($newItem);
        
        // إعادة التوجيه إلى صفحة العرض
        return redirect(route('imagetest2.index'));
        
    }

}