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
        Schema::table('tb_student', function (Blueprint $table) {
            $table->unsignedBigInteger('degree_id')->default(1)->change();

            $table->unsignedBigInteger('section_id')->default(1)->after('degree_id');

            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_student', function (Blueprint $table) {
            //
        });
    }
};
