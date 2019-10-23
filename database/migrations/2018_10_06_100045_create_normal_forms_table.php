<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNormalFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('normal_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reason')->nullable();
            $table->string('applied_for')->nullable();
            $table->string('applied_date')->nullable();
            $table->string('place_name_address')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('place_owner_name_address')->nullable();
            $table->string('permit_expiry_date')->nullable();
            $table->string('phone')->nullable();
            $table->string('chair_count')->nullable();
            $table->string('serving_area_count')->nullable();
            $table->string('info_provider_name_no')->nullable();
            $table->string('kitchen_count')->nullable();
            $table->string('inspected_at')->nullable();
            $table->unsignedInteger('normal_inspection_id')->nullable();
            $table->enum('status', ['draft', 'pending', 'processed', 'cancelled'])->default('draft');
            $table->softDeletes();
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
        Schema::dropIfExists('normal_forms');
    }
}
