<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_levels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('class_level_code')->unique();
            $table->string('degree');
            $table->integer('year');
            $table->string('section');
            $table->integer('no_of_students');
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
        Schema::dropIfExists('class_levels');
    }
}
