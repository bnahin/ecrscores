<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSbacDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sbac_data', function (Blueprint $table) {
            //Scale Level Integers
            // NULL == Unknown
            // 0 == Not Met
            // 1 == Near
            // 2 == Met
            // 3 == Exceeded

            $table->increments('id');
            $table->string('teacher');
            $table->string('fname');
            $table->string('lname');
            $table->bigInteger('ssid');
            $table->string('course');

            $table->integer('math_scale')->nullable();
            $table->unsignedTinyInteger('math_level')->nullable();

            $table->unsignedTinyInteger('reasoning')->nullable(); //Communicating and Reasoning
            $table->unsignedTinyInteger('concepts')->nullable(); //Concepts and Procedures
            $table->unsignedTinyInteger('modeling')->nullable(); //Problem Solving and Modeling/Data

            $table->unsignedInteger('ela_scale')->nullable();
            $table->unsignedTinyInteger('ela_level')->nullable();

            $table->unsignedTinyInteger('inquiry')->nullable();
            $table->unsignedTinyInteger('listening')->nullable();
            $table->unsignedTinyInteger('reading')->nullable();
            $table->unsignedTinyInteger('writing')->nullable();

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
        Schema::dropIfExists('sbac_data');
    }
}
