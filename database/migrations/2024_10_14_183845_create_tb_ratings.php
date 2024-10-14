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
        Schema::create('tb_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->string('activity1');
            $table->string('activity2');
            $table->string('activity3');
            $table->string('improvement1');
            $table->string('improvement2');
            $table->string('improvement3');
            $table->string('discipline');
            $table->string('extracurricular');
            $table->string('exam');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('tb_student');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_ratings');
    }
};
