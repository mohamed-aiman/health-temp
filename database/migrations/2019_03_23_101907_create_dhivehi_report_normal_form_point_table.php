<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDhivehiReportNormalFormPointTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dhivehi_report_normal_form_point', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dhivehi_report_id')->nullable();
            $table->unsignedInteger('normal_form_point_id')->nullable();
            $table->string('no')->nullable();
            $table->string('point_no')->nullable();
            $table->string('code')->nullable();
            $table->text('violation')->nullable();
            $table->text('recommendation')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('dhivehi_report_id')->references('id')->on('dhivehi_reports');
            $table->foreign('normal_form_point_id')->references('id')->on('normal_form_points');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dhivehi_report_normal_form_point');
    }
}
