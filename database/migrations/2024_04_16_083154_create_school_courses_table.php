<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_courses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('type')->default('n/a');
            $table->tinyInteger('years');
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
            $table->tinyInteger('certification_id')->unsigned()->index();
            $table->foreign('certification_id')->references('id')->on('list_dropdowns')->onDelete('cascade');
            $table->integer('school_id')->unsigned()->index();
            $table->foreign('school_id')->references('id')->on('school_campuses')->onDelete('cascade');
            $table->integer('course_id')->unsigned()->index();
            $table->foreign('course_id')->references('id')->on('list_courses')->onDelete('cascade');
            $table->boolean('is_active')->default(1);
            $table->boolean('is_synced')->default(0);
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
        Schema::dropIfExists('school_courses');
    }
};
