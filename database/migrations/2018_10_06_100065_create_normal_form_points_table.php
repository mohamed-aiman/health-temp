<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNormalFormPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('normal_form_points', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('normal_form_id')->nullable();
            $table->unsignedInteger('normal_point_id')->nullable();
            $table->unsignedInteger('normal_category_id')->nullable();
            $table->string('no')->nullable();
            $table->string('code')->nullable();
            $table->text('text')->nullable(); 
            $table->string('category')->nullable(); 
            $table->boolean('value')->default(false); 
            $table->boolean('not_applicable')->default(false); 
            $table->text('remarks')->nullable(); 
            $table->unsignedInteger('order')->nullable(); 
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('normal_form_id')->references('id')->on('normal_forms');
            $table->foreign('normal_point_id')->references('id')->on('normal_points');
            $table->foreign('normal_category_id')->references('id')->on('normal_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('normal_form_points');
    }
}
