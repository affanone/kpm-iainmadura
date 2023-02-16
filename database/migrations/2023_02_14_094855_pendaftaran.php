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
        Schema::table("pendaftarans", function ($table) {
            // status
            // 0 = register belum final
            // 1 = final dan minta persetujuan
            // 2 = persetujuan direject
            // 3 = persetujuan diterima
            // 4 = sudah masuk ke posko
            // 5 = tidak lulus
            // 6 = lulus
            $table
                ->tinyInteger("status")
                ->default(0)
                ->unsigned()
                ->after("subkpm_id");
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
