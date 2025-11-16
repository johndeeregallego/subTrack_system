<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Teacher's name
            $table->string('email')->unique(); // Teacher's email
            $table->string('department')->nullable(); // Optional department
            $table->boolean('is_absent')->default(false); // Default: not absent
            $table->boolean('is_available')->default(true); // Default: available
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
