<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNormalPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('normal_points', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no')->nullable();
            $table->string('code')->nullable();
            $table->text('text')->nullable(); 
            $table->unsignedInteger('normal_category_id')->nullable(); 
            // $table->string('group')->nullable(); 
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('order')->nullable(); 
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('normal_fileds');
    }
}
