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
        Schema::create("poskos", function ($table) {
            $table->engine = "InnoDB";
            $table->charset = "utf8";
            $table->collation = "utf8_unicode_ci";
            $table->uuid("id")->unique();
            $table->string('fakultas');
            $table->uuid("tahun_akademik_id");
            $table->text("config")->nullable();
            $table
                ->foreign("tahun_akademik_id")
                ->references("id")
                ->on("tahun_akademiks")
                ->onUpdate("cascade")
                ->onDelete("cascade");
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
