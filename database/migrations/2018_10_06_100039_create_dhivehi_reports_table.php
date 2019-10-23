<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDhivehiReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dhivehi_reports', function (Blueprint $table) {
            $table->increments('id');            
            $table->unsignedInteger('inspection_id')->nullable();
            // $table->longText('scope')->nullable();
            $table->longText('critical')->nullable();
            $table->longText('major')->nullable();
            $table->longText('minor')->nullable();
            $table->longText('tobacco')->nullable();

            $table->string('critical_totals')->nullable();
            $table->string('major_totals')->nullable();
            $table->string('minor_totals')->nullable();
            $table->string('tobacco_totals')->nullable();

            $table->string('fine_slip_numbers')->nullable();
            
            $table->string('purpose')->nullable();
            $table->string('place_name_address')->nullable();
            $table->string('place_owner_name_address')->nullable();
            $table->string('phone')->nullable();
            $table->string('information_provider')->nullable();
            $table->unsignedInteger('number_of_inspections')->nullable();
            $table->string('time_of_inspection')->nullable();


            $table->boolean('food_conclusion_1')->default(false);
            $table->boolean('food_conclusion_2')->default(false);
            $table->boolean('food_conclusion_2_days')->nullable();
            $table->boolean('food_conclusion_3')->default(false);
            $table->string('food_conclusion_3_date')->nullable();
            $table->boolean('food_conclusion_4')->default(false);
            $table->boolean('food_conclusion_5')->default(false);
            $table->boolean('food_conclusion_6')->default(false);
            $table->string('food_conclusion_6_amount')->nullable();
            $table->boolean('tobacco_conclusion_1')->default(false);
            $table->string('tobacco_conclusion_1_date')->nullable();
            $table->boolean('tobacco_conclusion_2')->default(false);
            $table->boolean('tobacco_conclusion_3')->default(false);
            $table->string('tobacco_conclusion_3_amount')->nullable();
            $table->boolean('phi_head_conclusion_1')->default(false);
            $table->boolean('phi_head_conclusion_2')->default(false);
            $table->boolean('phi_head_conclusion_3')->default(false);
            $table->string('phi_head_conclusion_3_date')->nullable();
            $table->boolean('phi_head_conclusion_4')->default(false);
            $table->string('phi_head_name')->nullable();
            $table->string('phi_head_sign')->nullable();
            $table->string('phi_head_date')->nullable();
            $table->boolean('tpcs_head_conclusion_1')->default(false);
            $table->boolean('tpcs_head_conclusion_2')->default(false);
            $table->boolean('tpcs_head_conclusion_3')->default(false);
            $table->string('tpcs_head_conclusion_3_date')->nullable();
            $table->boolean('tpcs_head_conclusion_4')->default(false);
            $table->string('tpcs_head_name')->nullable();
            $table->string('tpcs_head_sign')->nullable();
            $table->string('tpcs_head_date')->nullable();
            $table->string('from_business_name')->nullable();
            $table->string('from_business_position')->nullable();
            $table->string('from_business_sign')->nullable();
            $table->string('from_business_date')->nullable();
            $table->string('from_hpa_name')->nullable();
            $table->string('from_hpa_position')->nullable();
            $table->string('from_hpa_sign')->nullable();
            $table->string('from_hpa_date')->nullable();
            $table->json('grading')->nullable();

            $table->enum('status', ['draft', 'pending', 'processed', 'issued', 'cancelled'])->default('draft');
            $table->string('state')->default('generated');

            $table->unsignedInteger('issued_by')->nullable();
            $table->datetime('issued_on')->nullable();
            $table->string('received_by')->nullable();
            $table->string('hard_copy_path')->nullable();

            // $table->longText('areas')->nullable();
            // $table->longText('comments')->nullable();
            // $table->unsignedInteger('verified_by')->nullable();

            // $table->string('inspectionMember1Name')->nullable();
            // $table->string('inspectionMember1Designation')->nullable();
            // $table->string('inspectionMember1Date')->nullable();
            // $table->string('inspectionMember2Name')->nullable();
            // $table->string('inspectionMember2Designation')->nullable();
            // $table->string('inspectionMember2Date')->nullable();
            // $table->string('verifiedByName')->nullable();
            // $table->string('verifiedByDesignation')->nullable();
            // $table->string('verifiedByDate')->nullable();

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
        Schema::dropIfExists('dhivehi_reports');
    }
}
