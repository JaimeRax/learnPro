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
        Schema::create('tb_activity', function (Blueprint $table) {
            $table->id();
            $table->string('state');
            $table->string('name');
            $table->string('plucking');
            $table->string('date_entity');
            $table->string('bimester');
            $table->string('year');
            $table->unsignedBigInteger('general_assignment_id')->nullable();
            $table->foreign('general_assignment_id')->references('id')->on('tb_general_assignment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_activity');
    }
};
