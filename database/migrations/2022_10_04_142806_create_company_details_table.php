<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('company_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name');
            $table->string('company_name_bn');
            $table->enum('is_new_entrepreneur',['yes','no']);
            $table->integer('year_of_establishment');
            $table->string('company_size');
            $table->string('industry_type');
            $table->string('industry_areas');
            $table->longText('business_description');
            $table->string('business_trade_license_no');
            $table->string('rl_no')->nullable();
            $table->string('website_url');
            $table->string('contact_persons_name');
            $table->string('contact_persons_email');
            $table->string('contact_persons_designation');
            $table->string('contact_persons_phone');
            $table->string('location_country');
            $table->string('location_division');
            $table->string('location_district');
            $table->string('location_thana');
            $table->string('location_area');
            $table->string('location_area_bn');
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
        Schema::dropIfExists('company_details');
    }
};
