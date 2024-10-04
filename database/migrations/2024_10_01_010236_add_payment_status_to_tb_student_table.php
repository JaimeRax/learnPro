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
            $table->string('paymentStatus')->after('town_ethnicity')->default("INSOLVENTE");
            $table->integer('state')->default(2)->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_student', function (Blueprint $table) {
            $table->dropColumn('paymentStatus');
        });
    }
};