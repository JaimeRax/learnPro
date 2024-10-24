<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_in_charge', function (Blueprint $table) {

            $table->id();
            $table->string('charge_first_name');
            $table->string('charge_second_name')->nullable();
            $table->string('charge_first_lastname');
            $table->string('charge_second_lastname')->nullable();
            $table->string('charge_dpi');
            $table->integer('charge_phone');
            $table->string('charge_address');
            $table->string('charge_relationship')->nullable();
            $table->string('charge_comment')->nullable();
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
