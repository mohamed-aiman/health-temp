<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     //    CREATE TABLE Company (
     //     id BIGINT NOT NULL,
     //     name VARCHAR(255) NOT NULL,
     //     dhivehiName VARCHAR(255) DEFAULT NULL,
     //     country VARCHAR(3) DEFAULT NULL,
     //     identificationCode VARCHAR(255) DEFAULT NULL,
     //     dateOfInception DATE DEFAULT NULL,
     //     logo VARCHAR(255) DEFAULT NULL,
     //     createdAt TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
     //     updatedAt TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
     //     deletedAt TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
     //     isActive BOOLEAN DEFAULT NULL,
     //     isExpired BOOLEAN DEFAULT NULL,
     //     activeAt TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
     //     expireAt TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
     //     createdBy BIGINT DEFAULT NULL,
     //     updatedBy BIGINT DEFAULT NULL,
     //     PRIMARY KEY(id)
     // )

        Schema::create('businesses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_dv')->nullable();
            $table->string('phone')->nullable();
            $table->string('country')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('identification_code')->nullable();
            $table->date('date_of_inspection')->nullable();
            $table->string('logo')->nullable();
            $table->unsignedInteger('license_id')->nullable(); //active license 
            $table->unsignedInteger('active_application_id')->nullable(); //latest processed application 
            $table->boolean('is_active')->nullable();
            $table->boolean('is_expired')->nullable();
            $table->timestamp('active_at')->nullable();
            $table->timestamp('expire_at')->nullable();
            $table->unsignedInteger('termination_id')->nullable(); //active termination 
            $table->bigInteger('createdBy')->nullable();
            $table->bigInteger('updatedBy')->nullable();
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
        Schema::dropIfExists('businesses');
    }
}
