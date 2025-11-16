<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('substitutions', function (Blueprint $table) {
            $table->id();

            // ✅ Link to class_models (not 'classes')
            if (Schema::hasTable('class_models')) {
                $table->foreignId('class_id')
                    ->constrained('class_models')
                    ->onDelete('cascade');
            } else {
                $table->unsignedBigInteger('class_id')->nullable();
            }

            // ✅ Link to teachers table for both teacher_id and substitute_id
            if (Schema::hasTable('teachers')) {
                $table->foreignId('teacher_id')
                    ->constrained('teachers')
                    ->onDelete('cascade');

                $table->foreignId('substitute_id')
                    ->constrained('teachers')
                    ->onDelete('cascade');
            } else {
                $table->unsignedBigInteger('teacher_id')->nullable();
                $table->unsignedBigInteger('substitute_id')->nullable();
            }

            $table->string('time_slot');
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('substitutions');
    }
};
