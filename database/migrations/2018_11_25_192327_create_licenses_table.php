<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('business_id')->nullable();
            $table->unsignedInteger('application_id')->nullable();
            $table->string('type', 2)->nullable();
            $table->enum('license_type', ['food_new_registration', 'food_renewal', 'tobacco']);
            $table->string('service_type', 2)->nullable();
            $table->string('license_no')->nullable();
            $table->timestamp('issued_at')->nullable();
            $table->timestamp('expire_at')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->float('amount')->nullable();
            $table->string('receipt_no')->nullable();
            $table->timestamp('paid_on')->nullable();
            $table->string('receipt_path')->nullable();
            $table->string('hard_copy_path')->nullable();
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
        Schema::dropIfExists('licenses');
    }
}
