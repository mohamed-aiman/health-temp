<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnglishReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('english_reports', function (Blueprint $table) {
            $table->increments('id');            
            $table->unsignedInteger('inspection_id')->nullable();
            $table->longText('scope')->nullable();
            $table->longText('critical')->nullable();
            $table->longText('major')->nullable();
            $table->longText('observations')->nullable();
            $table->longText('areas')->nullable();
            $table->longText('comments')->nullable();
            // $table->unsignedInteger('verified_by')->nullable();

            $table->string('inspectionMember1Name')->nullable();
            $table->string('inspectionMember1Designation')->nullable();
            $table->string('inspectionMember1Date')->nullable();
            $table->string('inspectionMember2Name')->nullable();
            $table->string('inspectionMember2Designation')->nullable();
            $table->string('inspectionMember2Date')->nullable();
            $table->string('verifiedByName')->nullable();
            $table->string('verifiedByDesignation')->nullable();
            $table->string('verifiedByDate')->nullable();

            $table->enum('status', ['draft', 'pending', 'processed', 'issued', 'cancelled'])->default('draft');
            $table->string('state')->default('generated');

            $table->unsignedInteger('issued_by')->nullable();
            $table->datetime('issued_on')->nullable();
            $table->string('received_by')->nullable();
            $table->string('hard_copy_path')->nullable();

            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('issued_by')->references('id')->on('users');
            // $table->foreign('verified_by')->references('id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('english_reports');
    }
}
