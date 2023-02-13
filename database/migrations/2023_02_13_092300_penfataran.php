<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("pendaftarans", function ($table) {
            $table->engine = "InnoDB";
            $table->charset = "utf8";
            $table->collation = "utf8_unicode_ci";
            $table->uuid("id")->unique();
            $table->uuid("mahasiswa_id");
            $table->uuid("kpm_id");
            $table->timestamps();
            $table
                ->foreign("mahasiswa_id")
                ->references("id")
                ->on("mahasiswas")
                ->onUpdate("cascade")
                ->onDelete("cascade");
            $table
                ->foreign("kpm_id")
                ->references("id")
                ->on("kpms")
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
