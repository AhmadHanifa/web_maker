<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MigrationController extends Controller
{
    public function createModelWithCustomMigration(Request $request)
    {
        // استقبال المدخلات من الطلب
        $modelName = $request->input('model_name');
        $fields = $request->input('fields');
        $relationships = $request->input('relationships');

        // استخدام Artisan لإنشاء نموذج مع Migration
        Artisan::call('make:model', [
            'name' => $modelName,
            '--migration' => true,
        ]);

        // تحديد مسار ملف الـMigration
        $timestamp = date('Y_m_d_His');
        $migrationFileName = database_path("migrations/{$timestamp}_create_" . Str::snake(Str::plural($modelName)) . "_table.php");

        // بناء محتوى الـMigration ديناميكيًا
        $migrationContent = "<?php

        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;

        class Create" . ucfirst(Str::plural($modelName)) . "Table extends Migration
        {
            /**
             * Run the migrations.
             ;
             * @return void
             */
            public function up()
            {
                Schema::create('" . Str::snake(Str::plural($modelName)) . "', function (Blueprint $" . "table) {
                    $" . "table->id();\n";

        foreach ($fields as $field) {
            $migrationContent .= "                       $" . "table->{$field['type']}('{$field['name']}')";
            if (isset($field['nullable']) && $field['nullable']) {
                $migrationContent .= "->nullable()";
            }
            $migrationContent .= ";\n";
        }
        foreach ($relationships as $relationship) {
            $migrationContent .= "            \$table->foreignId('{$relationship['foreign_key']}')->constrained('{$relationship['references_table']}')->onDelete('{$relationship['on_delete']}');\n";
        }

        $migrationContent .= "                       $" . "table->timestamps();
                });
            }
       

        
            /**
             * Reverse the migrations.
             *
             * @return void
             */
            public function down()
            {
                Schema::dropIfExists('" . Str::snake(Str::plural($modelName)) . "');
            }
        }";

        // كتابة المحتوى المخصص إلى ملف الـMigration
        File::put($migrationFileName, $migrationContent);

        return response()->json(['message' => "Model and custom Migration for $modelName created successfully."]);
    }
}
