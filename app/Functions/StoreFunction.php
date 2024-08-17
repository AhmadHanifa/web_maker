<?php

namespace App\Functions;

use Illuminate\Http\Request;

trait StoreFunction
{
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
                $newItem[$key] = ImageHelper::handleImageUpload($file, 'uploads/ModalName_images');
            }
        }
        
        // إنشاء العنصر الجديد في قاعدة البيانات
        ModalName::create($newItem);
        
        // إعادة التوجيه إلى صفحة العرض
        return redirect(route('modalName.index.web'));
        
    }

}
