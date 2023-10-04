<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('user_type')->nullable();
            $table->text('title')->nullable()->comment('occupation');
            $table->string('employment_type')->nullable();
            $table->text('company_name')->nullable()->comment('Name of organization or institution');
            $table->text('designation_department')->nullable();
            $table->string('country_id')->nullable();
            $table->string('division_id')->nullable();
            $table->string('district_id')->nullable();
            $table->string('location_type')->nullable();
            $table->string('start_date')->nullable()->comment('Date of joining (if job holder)');
            $table->string('end_date')->nullable();
            $table->string('experience')->nullable();
            $table->string('industry')->nullable();
            $table->text('description')->nullable();
            $table->enum('is_current', ['Yes', 'No'])->nullable();

            // $table->foreignId('job_seeker_id')->constrained();
            // $table->foreignId('designation_id')->constrained();
            // $table->string('organization_name');
            // $table->longText('organization_location');
            // $table->longText('job_description')->nullable();
            // $table->date('joining_date');
            // $table->date('leave_date')->nullable();
            // $table->integer('experience')->nullable();
            // $table->enum('year_or_month_or_day',['Year','Month','Day'])->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('experiences');
    }
};
