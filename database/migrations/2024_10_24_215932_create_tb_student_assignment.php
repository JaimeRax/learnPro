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
        Schema::create('tb_student_assignment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('tb_student');
            $table->unsignedBigInteger('general_assignment_id')->nullable();
            $table->foreign('general_assignment_id')->references('id')->on('tb_general_assignment');
            $table->unsignedBigInteger('degrees_id');
            $table->foreign('degrees_id')->references('id')->on('degrees');
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('sections');
            $table->string('year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_student_assignment');
    }
};
