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
        Schema::create("posko_pendaftarans", function ($table) {
            $table->engine = "InnoDB";
            $table->charset = "utf8";
            $table->collation = "utf8_unicode_ci";
            $table->uuid("id")->unique();
            $table->uuid("posko_id");
            $table->uuid("pendaftaran_id");
            $table->timestamps();
            $table
                ->foreign("posko_id")
                ->references("id")
                ->on("poskos")
                ->onUpdate("cascade");
            $table
                ->foreign("pendaftaran_id")
                ->references("id")
                ->on("pendaftarans")
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
