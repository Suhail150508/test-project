<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_seekers', function (Blueprint $table) {
            $table->id();
            $table->longText('profile_objective');
            $table->integer('ewu_id_no')->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->string('gender')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_occupation')->nullable();
            $table->string('designation')->nullable();
            $table->string('current_organization')->nullable();
            $table->string('current_possition')->nullable();
            $table->string('personal_contact')->nullable();
            $table->string('office_contact')->nullable();
            $table->string('linkedin_profile_link')->nullable();
            $table->string('fb_profile_link')->nullable();
            $table->string('personal_contact_number')->unique();
            $table->string('contact_number_office')->nullable()->unique();
            $table->integer('convocation_year')->nullable();
            $table->integer('experience_year')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('email')->unique();
            $table->string('job_application_status')->nullable();
            $table->integer('cgpa')->nullable();
            $table->string('resume')->nullable();
            $table->date('dob')->nullable();
            // $table->foreignId('department_id')->constrained();
            // $table->foreignId('major_id')->constrained('major_minors')->nullable();
            // $table->foreignId('minor_id')->constrained('major_minors')->nullable();
            $table->integer('passing_year')->nullable();
            $table->integer('passing_semister')->nullable();
            $table->integer('ssc_result')->nullable();
            $table->integer('hsc_result')->nullable();
            // $table->json('job_interested_area_ids')->nullable();
            // $table->json('skill_ids')->nullable();
            // $table->json('co_curricular_activity_ids')->nullable();
            // $table->json('training_ids')->nullable();
            // $table->json('workshop_ids')->nullable();
            // $table->json('achievement_ids')->nullable();
            // $table->json('professional_interest_ids')->nullable();
            // $table->json('personal_interest_ids')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->nullable();
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
        Schema::dropIfExists('job_seekers');
    }
};
