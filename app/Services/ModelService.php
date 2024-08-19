<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ModelService
{
    /**
     * إنشاء موديل ديناميكي بناءً على اسم الجدول، الحقول المعبأة، الأعمدة المخفية، والعلاقات
     *
     * @param string $tableName
     * @param array $fillable
     * @param array $hidden
     * @param array $relations
     * @return void
     */
    public function createModel($tableName, $columns = [], $relations = null , $hidden = null)
    {

        $fillable = $columns ? "['" . implode("', '", $columns) . "']" : "[]";
        $hiddenFields = $hidden ? "['" . implode("', '", $hidden) . "']" : "[]";
        $tableName = Str::snake(Str::pluralStudly($tableName));

        // تحويل اسم الجدول إلى اسم موديل
        $modelName= ucfirst(Str::singular($tableName));
        // dd($modelName);
        // مسار ملف الموديل
        $modelPath = app_path("Models/{$modelName}.php");

        // توليد العلاقات فقط إذا كانت موجودة
        $relationsContent = '';
        if ($relations) {
            $relationsContent = $this->generateRelations($relations);
        }

        // محتوى الموديل
        $modelTemplate = <<<EOD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class {$modelName} extends Model
{
    protected \$table = '{$tableName}';
    protected \$fillable = {$fillable};
    protected \$hidden = {$hiddenFields};

    {$relationsContent}
}
EOD;

        // إنشاء ملف الموديل
        File::put($modelPath, $modelTemplate);

        // انشاء العلاقة في المودل الثاني

        $this->generateModelRefrenceRelations($relations , $tableName);
    }

    /**
     * إنشاء نص العلاقات للموديل
     *
     * @param array $relations
     * @return string
     */
    private function generateRelations($relations)
    {
        $relationMethods = '';

        foreach ($relations as $relation) {
            $relationMethods .= $this->generateRelationMethod($relation);
        }

        return $relationMethods;
    }


    /**
     * إنشاء العلاقة في المودل المرجع
     *
     * @param array $relation
     * @return string
     */

     private function generateModelRefrenceRelations($relations , $tableName)
     {

        foreach ($relations as $relation) {

            $modelRefrence = Str::singular(Str::studly($relation['table_refrence']));

            $toRelation[] = '';
            $toRelation['table_refrence'] = $tableName;
            $toRelation['relation_name'] = 'many';
            $modelRefPath = app_path("Models/{$modelRefrence}.php");
            $modelContent = File::get($modelRefPath);

             // تحديد موضع إضافة الطريقة الجديدة (قبل نهاية الفئة)
            $insertPosition = strrpos($modelContent, '}');

            $newRelation =$this->generateRelationMethod($toRelation);
            // dd($newRelation , $insertPosition);
            $updatedContent = substr($modelContent, 0, $insertPosition) . $newRelation . substr($modelContent, $insertPosition);
            // dd($updatedContent);
            File::put($modelRefPath, $updatedContent);

        }
     }
    /**
     * إنشاء نص دالة علاقة معينة
     *
     * @param array $relation
     * @return string
     */
    private function generateRelationMethod($relation)
    {
        if($relation['relation_name'] == 'one_to_many') {
            $type = 'belongsTo';
            $name = Str::camel(Str::singular($relation['table_refrence']));
        }else{
            $type = 'hasMany';
            $name = Str::camel($relation['table_refrence']);
        }
        $model = Str::singular(Str::studly($relation['table_refrence']));

        return <<<EOD

    public function {$name}()
    {
        return \$this->{$type}({$model}::class);
    }
        
EOD;
    }
}

