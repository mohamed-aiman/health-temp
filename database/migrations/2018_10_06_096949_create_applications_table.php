<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('business_id')->nullable();
            $table->enum('status', ['draft', 'pending', 'processed', 'cancelled'])->default('draft');
            $table->string('_1applicationType')->nullable();
            $table->string('_1date')->nullable();
            $table->string('_1registerPlace')->nullable();
            $table->string('_1registrationNumber')->nullable();
            $table->string('_1renewLicense')->nullable();
            $table->string('_1toRegisterPlace')->nullable();
            $table->string('_1toRenewLicense')->nullable();
            $table->string('_1tobaccoOrFood')->nullable();
            $table->string('_1wantLicenseIndhivehi')->nullable();
            $table->string('_1wantLicenseInenglish')->nullable();
            $table->string('_2address')->nullable();
            $table->string('_2idNo')->nullable();
            $table->string('_2name')->nullable();
            $table->string('_2phone')->nullable();
            $table->string('_3address')->nullable();
            $table->string('_3idNo')->nullable();
            $table->string('_3name')->nullable();
            $table->string('_3phone')->nullable();
            $table->string('_4blockNumber')->nullable();
            $table->string('_4numberOfChairs')->nullable();
            $table->string('_4numberOfServingAreas')->nullable();
            $table->string('_4placeAddress')->nullable();
            $table->string('_4placeName')->nullable();
            $table->string('_4road')->nullable();
            $table->string('_5cat101')->nullable();
            $table->string('_5cat101text')->nullable();
            $table->string('_5cat11')->nullable();
            $table->string('_5cat12')->nullable();
            $table->string('_5cat13')->nullable();
            $table->string('_5cat14')->nullable();
            $table->string('_5cat15')->nullable();
            $table->string('_5cat21')->nullable();
            $table->string('_5cat31')->nullable();
            $table->string('_5cat32')->nullable();
            $table->string('_5cat33')->nullable();
            $table->string('_5cat41')->nullable();
            $table->string('_5cat42')->nullable();
            $table->string('_5cat43')->nullable();
            $table->string('_5cat51')->nullable();
            $table->string('_5cat61')->nullable();
            $table->string('_5cat62')->nullable();
            $table->string('_5cat71')->nullable();
            $table->string('_5cat81')->nullable();
            $table->string('_5cat91')->nullable();
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
        Schema::dropIfExists('applications');
    }
}
