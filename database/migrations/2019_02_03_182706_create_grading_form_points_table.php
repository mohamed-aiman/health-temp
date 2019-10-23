<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradingFormPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grading_form_points', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('grading_form_id')->nullable();
            $table->unsignedInteger('grading_point_id')->nullable();
            $table->unsignedInteger('grading_category_id')->nullable();
            $table->string('no')->nullable();
            $table->string('code')->nullable();
            $table->text('text')->nullable(); 
            $table->string('category')->nullable(); 
            $table->boolean('value')->default(false); 
            $table->boolean('not_applicable')->default(false); 
            $table->unsignedInteger('order')->nullable(); 
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('grading_form_id')->references('id')->on('grading_forms');
            $table->foreign('grading_point_id')->references('id')->on('grading_points');
            $table->foreign('grading_category_id')->references('id')->on('grading_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grading_form_points');
    }
}
