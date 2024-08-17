<?php

namespace App\Http\Controllers\controlPanal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Functions\CreateFunction;
use \App\Functions\EditFunction;
use \App\Functions\IndexFunction;
use \App\Functions\StoreFunction;
use \App\Functions\UpdateFunction;

use App\Models\Imagetest1;

class Imagetest1Controller extends Controller
{
    public function create()
    {
        return view('imagetest1.create');
    }
public function edit($id)
    {
        $imagetest1 = Imagetest1::findOrFail($id);
        return view('imagetest1.edit',compact('imagetest1'));
    }
public function index()
    {

        $imagetest1s= Imagetest1::get();
        return view('imagetest1.index',compact('imagetest1s'));

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
                $newItem[$key] = ImageHelper::handleImageUpload($file, 'uploads/Imagetest1_images');
            }
        }
        
        // إنشاء العنصر الجديد في قاعدة البيانات
        Imagetest1::create($newItem);
        
        // إعادة التوجيه إلى صفحة العرض
        return redirect(route('imagetest1.index'));
        
    }

}