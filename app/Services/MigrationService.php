<?php
namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class MigrationService
{
    public static function generateMigrationContent($modelName, $fields, $relationships = null)
    {
        // توليد محتوى الحقول
        $fieldsContent = self::generateFieldsContent($fields);

        // توليد محتوى العلاقات فقط إذا كانت موجودة
        $relationshipsContent = '';
        if ($relationships) {
            $relationshipsContent = self::generateRelationshipsContent($relationships);
        }

        // تحديد اسم الميجريشن واسم الجدول
        $migrationName = 'create_' . Str::snake(Str::pluralStudly($modelName)) . '_table';
        $tableName = Str::snake(Str::pluralStudly($modelName));

        // توليد محتوى الميجريشن
        $migrationContent = <<<EOD
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('{$tableName}', function (Blueprint \$table) {
            \$table->id();
            {$fieldsContent}
            {$relationshipsContent}
            \$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('{$tableName}');
    }
};
EOD;

        // تحديد مسار الملف النسبي
        $fileName = date('Y_m_d_His') . "_{$migrationName}.php";
        $filePath = database_path('migrations/' . $fileName);

        // كتابة المحتوى إلى الملف
        File::put($filePath, $migrationContent);

        // تشغيل الميجريشن
        self::runMigration($fileName);
    }

    private static function generateFieldsContent($fields)
    {
        $content = '';
        foreach ($fields as $field) {
            $nullable = isset($field['nullable']) && $field['nullable'] ? '->nullable()' : '';
            $content .= "\$table->{$field['type']}('{$field['name']}'){$nullable};\n";
        }
        return $content;
    }

    private static function generateRelationshipsContent($relationships)
    {
        $content = '';
        foreach ($relationships as $relationship) {
            $content .= "\$table->foreignId('{$relationship['foreign_key']}')->constrained('{$relationship['references_table']}')->onDelete('{$relationship['on_delete']}');\n";
        }
        return $content;
    }

    public static function runMigration($fileName)
    {
        // Use the relative path directly in the migration command
        $migrationFilePath = 'migrations/' . $fileName;

        if (File::exists(database_path($migrationFilePath))) {
            // Run the specific migration file
            Artisan::call('migrate', [
                '--path' => 'database/' . $migrationFilePath,
            ]);
        } else {
            throw new \Exception("The migration file {$migrationFilePath} does not exist.");
        }
    }
}

?>
