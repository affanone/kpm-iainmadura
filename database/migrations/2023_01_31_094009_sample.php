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
        // Schema::create('sample', function ($table) {
        //     $table->engine = 'InnoDB';
        //     $table->charset = 'utf8';
        //     $table->collation = 'utf8_unicode_ci';
        //     $table->uuid('id')->unique();
        //     $table->uuid('menu_id')->nullable();
        //     $table->string('title');
        //     $table->longtext('content')->nullable();
        //     $table->timestamps();
        //     $table
        //         ->foreign('menu_id')
        //         ->references('id')
        //         ->on('menus')
        //         ->onUpdate('cascade')
        //         ->onDelete('cascade');
        // });
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
