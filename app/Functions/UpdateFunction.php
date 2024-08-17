<?php

namespace App\Functions;

use Illuminate\Http\Request;

trait UpdateFunction
{
    public function update(Request $request, $id)
    {
        // جلب العنصر المراد تحديثه من قاعدة البيانات
        $updateItem = ModalName::findOrFail($id);
    
        // الحصول على جميع البيانات من الطلب
        $updateData = $request->all();
    
        // الحصول على جميع الملفات من الطلب (في حال وجود صور)
        $files = $request->allFiles();
    
        // حلقة عبر الملفات لمعرفة ما إذا كانت صورة
        foreach ($files as $key => $file) {
            // التحقق مما إذا كان الملف صورة
            if ($file->isValid() && in_array($file->extension(), ['jpeg', 'png', 'jpg', 'gif', 'svg','webp'])) {
                // حذف الصورة القديمة إذا وجدت
                if ($updateItem[$key]) {
                    deleteImage($updateItem[$key]); // استخدم الهيلبر لحذف الصورة القديمة
                }
                // استخدام الهيلبر لتحميل الصورة الجديدة والحصول على مسارها
                $updateData[$key] = ImageHelper::handleImageUpload($file, 'uploads/modalname_images');
            }
        }
    
        // تحديث البيانات في قاعدة البيانات
        $updateItem->update($updateData);
    
        // إعادة التوجيه إلى صفحة العرض
        return redirect(route('modalName.index.web'));
    }
    

}
