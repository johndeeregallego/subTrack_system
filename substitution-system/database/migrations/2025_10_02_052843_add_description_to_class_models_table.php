<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('class_models') && !Schema::hasColumn('class_models', 'description')) {
            Schema::table('class_models', function (Blueprint $table) {
                $table->string('description')->nullable()->after('name');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('class_models') && Schema::hasColumn('class_models', 'description')) {
            Schema::table('class_models', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }
    }
};
