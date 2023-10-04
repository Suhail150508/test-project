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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->integer('ewu_id_no')->nullable();
            $table->foreignId('major_id')->nullable()->constrained('major_minors');
            $table->foreignId('minor_id')->nullable()->constrained('major_minors');
            $table->foreignId('department_id')->nullable()->constrained();
            $table->json('job_interested_area_ids')->nullable();;
            $table->json('skill_ids')->nullable();
            $table->json('training_ids')->nullable();
            $table->json('workshop_ids')->nullable();
            $table->json('achievement_ids')->nullable();
            $table->json('professional_interest_ids')->nullable();
            $table->json('personal_interest_ids')->nullable();
            $table->json('co_curricular_activity_ids')->nullable();
            $table->longText('profile_objective')->nullable();;
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('gender')->nullable();
            $table->string('personal_contact_number')->unique()->nullable();
            $table->string('contact_number_office')->nullable()->unique();
            $table->integer('convocation_year')->nullable();
            $table->integer('experience_year')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('job_application_status')->nullable();
            $table->string('fb_profile_link')->nullable();
            $table->string('linkedin_profile_link')->nullable();
            $table->string('resume')->nullable();
            $table->date('dob')->nullable();
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('students');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
