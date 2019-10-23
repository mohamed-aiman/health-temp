<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradingInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grading_inspections', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('business_id');
            $table->unsignedInteger('application_id')->nullable();
            $table->timestamp('inspection_at')->nullable();
            $table->enum('status', ['scheduled', 'finished', 'cancelled'])->default('scheduled');
            $table->unsignedInteger('grading_form_id')->nullable();
            $table->unsignedInteger('follow_up_id')->nullable();
            $table->unsignedInteger('followed_to_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('follow_up_id')->references('id')->on('grading_inspections');
            $table->foreign('followed_to_id')->references('id')->on('grading_inspections');
            $table->foreign('business_id')->references('id')->on('businesses');
            $table->foreign('application_id')->references('id')->on('applications');
            $table->foreign('grading_form_id')->references('id')->on('grading_forms');
            // $table->unsignedInteger('grading_english_form_id')->nullable();
            // $table->foreign('grading_english_form_id')->references('id')->on('english_forms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grading_inspections');
    }
}
