<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("kpms", function ($table) {
            // status
            // 0 = institut
            // 1 = fakultas
            $table
                ->tinyInteger("tipe")
                ->default(0)
                ->unsigned()
                ->after("config");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
