<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePercentilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('percentiles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('psat_data_id')->index();
            $table->enum('type', ['school', 'teacher', 'period']);
            $table->integer('percent');
            $table->timestamps();

            $table->foreign('psat_data_id')
                ->references('id')->on('psat_data')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('percentiles');
    }
}
