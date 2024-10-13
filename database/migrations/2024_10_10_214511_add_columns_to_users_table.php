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
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->after('username')->nullable();
            $table->string('second_name')->after('first_name')->nullable();
            $table->string('first_lastname')->after('second_name')->nullable();
            $table->string('second_lastname')->after('first_lastname')->nullable();
            $table->string('dpi')->after('second_lastname')->nullable();
            $table->string('phone')->after('dpi')->nullable();
            $table->string('academic_degree')->after('phone')->nullable();
            $table->string('service_time')->after('academic_degree')->nullable();
            $table->string('address')->after('service_time')->nullable();
            $table->boolean('state')->default(1)->after('password');
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'second_name',
                'first_lastname',
                'second_lastname',
                'dpi',
                'phone',
                'academic_degree',
                'service_time',
                'address'
            ]);
            $table->string('name')->after('username');
        });
    }
};
