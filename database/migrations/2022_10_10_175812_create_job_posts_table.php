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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('job_category_id')->nullable()->constrained();
            $table->foreignId('job_sub_category_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('headline')->nullable();
            $table->string('job_title')->nullable();
            $table->longText('job_details')->nullable();

            // $table->foreignId('division_id')->constrained();
            // $table->foreignId('district_id')->constrained();
            // $table->foreignId('thana_id')->constrained();

            $table->string('job_code')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_business')->nullable();
            $table->string('company_details')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('company_address')->nullable();
            $table->string('industry_type')->nullable();
            $table->string('website_address')->nullable();
            $table->longText('benefits')->nullable();
            $table->integer('no_of_vacancies')->nullable();
            $table->enum('employment_status',['Full Time','Part Time','Contractual','Internship','Freelance'])->default('Full Time');
            $table->date('job_publish_date')->nullable();
            $table->date('job_deadline')->nullable();

            // $table->string('special_instruction')->nullable();

            $table->string('resume_receiver_email')->nullable();;
            $table->enum('job_level',['Entry','Mid','Top'])->default('Entry');
            $table->longText('job_context')->nullable();
            $table->longText('job_responsibilities')->nullable();
            $table->longText('requirment')->nullable();
            $table->enum('job_workplace',['Work at office','Work from home'])->default('Work at office');

            // $table->enum('job_location_type',['Inside Bangladesh','Outside Bangladesh'])->default('Inside Bangladesh');
            // $table->string('salary_negotiable')->nullable();

            $table->integer('min_salary')->nullable();
            $table->integer('max_salary')->nullable();

            // $table->longText('additional_salary_info')->nullable();
            // $table->enum('lunch_facilities',['Partially Subsidize','Full Subsidize','No Subsidize'])->default('Partially Subsidize');
            // $table->enum('salary_review',['Half Yearly','Yearly'])->default('Yearly');

            $table->integer('festival_bonuses')->nullable();
            $table->enum('gender',['Male','Female','Both','Other'])->nullable();

            // $table->integer('min_age')->nullable();
            // $table->integer('max_age')->nullable();
            // $table->longText('additional_requirement')->nullable();
            // $table->enum('need_experience',['Yes','No'])->nullable();

            $table->integer('min_experience')->nullable();

            // $table->integer('max_experience')->nullable();
            // $table->enum('is_fresher_allowed',['Yes','No'])->default('No');

            $table->enum('min_academic_level',['SSC','HSC','Graduate','Post-Graduate','PhD'])->default('Graduate');

            // $table->json('department_ids');
            // $table->json('professional_certification_ids');
            // $table->json('skill_ids')->nullable();
            // $table->json('training_ids')->nullable();
            // $table->json('job_area_districts');

            $table->enum('is_approved', ['Yes', 'No'])->default('No');
            $table->enum('status', ['Active', 'Inactive'])->nullable()->default('Active');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
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
        Schema::dropIfExists('job_posts');
    }
};
