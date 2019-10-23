<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fines', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('business_id')->nullable();
            $table->unsignedInteger('inspection_id')->nullable();
            $table->unsignedInteger('grading_inspection_id')->nullable();
            $table->float('amount')->nullable();
            $table->string('fine_slip_no')->unique();
            $table->string('fine_slip_path')->unique();
            $table->timestamp('fined_on')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->string('receipt_no')->nullable();
            $table->timestamp('paid_on')->nullable();
            $table->string('receipt_path')->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedInteger('fine_type_id');
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
        Schema::dropIfExists('fines');
    }
}
