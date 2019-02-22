<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoreRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_ranges', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('year');
            $table->string('type');
            $table->integer('level');
            $table->integer('min');
            $table->integer('max');

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
        Schema::dropIfExists('score_ranges');
    }
}
