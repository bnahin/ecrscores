<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePsatDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psat_data', function (Blueprint $table) {
            $table->increments('id');
            $table->string('teacher');
            $table->string('fname');
            $table->string('lname');
            $table->bigInteger('ssid');
            $table->string('course');
            $table->unsignedInteger('readwrite')->nullable(); //Possible NS
            $table->unsignedInteger('math')->nullable(); //Possible NS
            $table->unsignedInteger('total')->nullable(); //Possible NS
            $table->integer('grade'); //From filename
            $table->char('year'); //Ex. 19-20
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
        Schema::dropIfExists('psat_data');
    }
}
