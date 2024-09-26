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
        Schema::create('tb_in_charge', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('second_name');
            $table->string('first_lastname');
            $table->string('second_lastname');
            $table->integer('dpi');
            $table->integer('phone');
            $table->string('address');
            $table->string('relationship')->nullable();
            $table->string('comment')->nullable();
            $table->boolean('state')->default(1);
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
        Schema::dropIfExists('tb_in_charge');
    }
};
