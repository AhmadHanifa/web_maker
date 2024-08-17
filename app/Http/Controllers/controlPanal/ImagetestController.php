<?php

namespace App\Http\Controllers\controlPanal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Functions\CreateFunction;
use \App\Functions\EditFunction;
use \App\Functions\IndexFunction;
use \App\Functions\StoreFunction;
use \App\Functions\UpdateFunction;

use App\Models\Imagetest;

class ImagetestController extends Controller
{
    public function create()
    {
        return view('imagetest.create');
    }
public function edit($id)
    {
        $imagetest = Imagetest::findOrFail($id);
        return view('imagetest.edit',compact('imagetest'));
    }
public function index()
    {

        $imagetests= Imagetest::get();
        return view('imagetest.index',compact('imagetests'));

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
                $newItem[$key] = handleImageUpload($file, 'uploads/Imagetest_images');
            }
        }
        
        // إنشاء العنصر الجديد في قاعدة البيانات
        Imagetest::create($newItem);
        
        // إعادة التوجيه إلى صفحة العرض
        return redirect(route('imagetest.index'));
        
    }

}