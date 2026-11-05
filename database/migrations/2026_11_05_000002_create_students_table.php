<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');
            $table->string('student_name');
            $table->string('email');
            $table->string('gender', 20)->default('Male');
            $table->date('dob')->nullable();
            $table->string('enrollment')->nullable();
            $table->date('enrollment_date');
            $table->text('description')->nullable();
            $table->foreignId('department_id')->constrained('departments', 'dept_id')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
