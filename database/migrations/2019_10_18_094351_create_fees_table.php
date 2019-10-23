<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('business_id')->nullable();
            $table->float('amount')->nullable();
            $table->string('fee_slip_no')->unique();
            $table->string('fee_slip_path')->unique();
            $table->timestamp('applied_on')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->string('receipt_no')->nullable();
            $table->timestamp('paid_on')->nullable();
            $table->string('receipt_path')->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedInteger('fee_type_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('business_id')->references('id')->on('businesses');
            $table->foreign('fee_type_id')->references('id')->on('fee_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fees');
    }
}
