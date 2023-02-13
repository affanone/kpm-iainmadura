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
        Schema::create("dokumen_pendaftarans", function ($table) {
            $table->engine = "InnoDB";
            $table->charset = "utf8";
            $table->collation = "utf8_unicode_ci";
            $table->uuid("id")->unique();
            $table->uuid("pendaftaran_id");
            $table->string("name");
            $table->string("url");
            $table->string("md5");
            $table->integer("size");
            $table->string("extension", 5)->nullable();
            $table->text("desc");
            $table->timestamps();
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
