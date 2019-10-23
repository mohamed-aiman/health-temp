<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspections', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('business_id');
            $table->unsignedInteger('application_id')->nullable();
            $table->unsignedInteger('complaint_id')->nullable();
            $table->unsignedInteger('inspector_id')->nullable();
            $table->timestamp('inspection_at')->nullable();
            $table->string('type')->nullable();
            $table->string('reason')->nullable();
            $table->string('remarks')->nullable();
            $table->boolean('is_fined')->default(false);
            $table->boolean('is_followup_required')->default(false);
            $table->timestamp('report_handed_over_at')->nullable();
            $table->enum('status', ['created', 'scheduled', 'finished', 'cancelled'])->default('created');
            $table->string('state')->default('created');
            $table->boolean('is_graded')->default(false);
            $table->string('grading_certificate_path')->nullable();
            $table->unsignedInteger('dhivehi_report_id')->nullable();
            $table->unsignedInteger('english_report_id')->nullable();
            $table->unsignedInteger('follow_up_id')->nullable();
            $table->unsignedInteger('followed_to_id')->nullable();
            $table->unsignedInteger('normal_form_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('followed_to_id')->references('id')->on('inspections');
            $table->foreign('follow_up_id')->references('id')->on('inspections');
            $table->foreign('business_id')->references('id')->on('businesses');
            $table->foreign('application_id')->references('id')->on('applications');
            $table->foreign('complaint_id')->references('id')->on('complaints');
            $table->foreign('inspector_id')->references('id')->on('users');
            $table->foreign('dhivehi_report_id')->references('id')->on('dhivehi_reports');
            $table->foreign('english_report_id')->references('id')->on('english_reports');
            $table->foreign('normal_form_id')->references('id')->on('normal_forms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspections');
    }
}
