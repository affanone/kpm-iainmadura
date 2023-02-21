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
        Schema::table("poskos", function ($table) {
            $table->uuid("dpl_id")->after('tahun_akademik_id');
            $table
                ->foreign("dpl_id")
                ->references("id")
                ->on("dpls")
                ->onUpdate("cascade");
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
