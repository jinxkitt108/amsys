<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadedCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loaded_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('instructor_id')->unsigned();
            $table->integer('course_id')->unsigned();
            $table->integer('class_id')->unsigned();
            $table->string('course_code');
            $table->string('course_description');
            $table->string('year_and_section');
            $table->integer('no_of_students');
            $table->integer('no_of_units');
            $table->integer('lec');
            $table->integer('lab');
            $table->integer('total');
            $table->timestamps();

            $table->foreign('instructor_id')
            ->references('id')->on('instructors');
            $table->foreign('course_id')
            ->references('id')->on('courses');
            $table->foreign('class_id')
            ->references('id')->on('classes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loaded_courses');
    }
}
