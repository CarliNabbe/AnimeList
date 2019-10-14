<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListAnimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_animes', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->integer('list_id')->unsigned();
            // $table->foreign('list_id')->references('id')->on('lists');
            // $table->integer('anime_id')->unsigned();
            // $table->foreign('anime_id')->references('id')->on('animes');
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
        Schema::dropIfExists('list_animes');
    }
}
