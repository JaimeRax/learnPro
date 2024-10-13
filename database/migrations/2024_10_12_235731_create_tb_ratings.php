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
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->string('activity_1');
            $table->string('activity_2');
            $table->string('activity_3');
            $table->string('improvement_1');
            $table->string('improvement_2');
            $table->string('improvement_3');
            $table->string('discipline');
            $table->string('extracurricular');
            $table->string('exam');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('tb_student')->onDelete('cascade');
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
