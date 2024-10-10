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
        Schema::table('tb_in_charge', function (Blueprint $table) {
            $table->string('charge_first_name_2')->nullable();
            $table->string('charge_second_name_2')->nullable();
            $table->string('charge_first_lastname_2')->nullable();
            $table->string('charge_second_lastname_2')->nullable();
            $table->string('charge_dpi_2')->nullable();
            $table->integer('charge_phone_2')->nullable();
            $table->string('charge_address_2')->nullable();
            $table->string('charge_relationship_2')->nullable();
            $table->string('charge_comment_2')->nullable();
            $table->string('charge_first_name_3')->nullable();
            $table->string('charge_second_name_3')->nullable();
            $table->string('charge_first_lastname_3')->nullable();
            $table->string('charge_second_lastname_3')->nullable();
            $table->string('charge_dpi_3')->nullable();
            $table->integer('charge_phone_3')->nullable();
            $table->string('charge_address_3')->nullable();
            $table->string('charge_relationship_3')->nullable();
            $table->string('charge_comment_3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_in_charge', function (Blueprint $table) {
            //
            $table->dropColumn([
                'charge_first_name_2',
                'charge_second_name_2',
                'charge_first_lastname_2',
                'charge_second_lastname_2',
                'charge_dpi_2',
                'charge_phone_2',
                'charge_address_2',
                'charge_relationship_2',
                'charge_comment_2',
                'charge_first_name_3',
                'charge_second_name_3',
                'charge_first_lastname_3',
                'charge_second_lastname_3',
                'charge_dpi_3',
                'charge_phone_3',
                'charge_address_3',
                'charge_relationship_3',
                'charge_comment_3',
            ]);
        });
    }
};
