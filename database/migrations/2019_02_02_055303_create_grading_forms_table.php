<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradingFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grading_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('place_name')->nullable();
            $table->string('food_registration_no')->nullable();
            $table->string('owner')->nullable();
            $table->string('inspection_date')->nullable();
            $table->string('permit_limit')->nullable();
            $table->string('phone')->nullable();
            $table->string('reason')->nullable();
            $table->string('information_provider')->nullable();
            $table->unsignedInteger('grading_inspection_id')->nullable();
            $table->enum('status', ['draft', 'pending', 'processed', 'cancelled'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grading_forms');
    }
}
