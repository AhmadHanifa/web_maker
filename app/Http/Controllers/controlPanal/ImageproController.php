<?php

namespace App\Http\Controllers\controlPanal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Functions\CreateFunction;
use \App\Functions\EditFunction;
use \App\Functions\IndexFunction;
use \App\Functions\StoreFunction;
use \App\Functions\UpdateFunction;

use App\Models\Imagepro;

class ImageproController extends Controller
{
    public function create()
    {
        return view('imagepro.create');
    }
public function edit($id)
    {
        $imagepro = Imagepro::findOrFail($id);
        return view('imagepro.edit',compact('imagepro'));
    }
public function index()
    {

        $imagepros= Imagepro::get();
        return view('imagepro.index',compact('imagepros'));

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
                $newItem[$key] = handleImageUpload($file, 'uploads/Modalname_images');
            }
        }
        
        // إنشاء العنصر الجديد في قاعدة البيانات
        Imagepro::create($newItem);
        
        // إعادة التوجيه إلى صفحة العرض
        return redirect(route('imagepro.index'));
        
    }

}