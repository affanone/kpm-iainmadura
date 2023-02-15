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
        Schema::create("dpls", function ($table) {
            $table->engine = "InnoDB";
            $table->charset = "utf8";
            $table->collation = "utf8_unicode_ci";
            $table->uuid("id")->unique();
            $table
                ->string("nip", 18)
                ->unique()
                ->nullable();
            $table
                ->string("nidn", 18)
                ->unique()
                ->nullable();
            $table->string("nama", 50);
            $table->enum("kelamin", ["L", "P"])->nullable();
            $table->string("prodi");
            $table->string("fakultas");
            $table->string("hp", 16);
            $table->string("alamat");
            $table->timestamps();
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
