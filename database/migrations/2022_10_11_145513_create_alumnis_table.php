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
        Schema::create('alumnis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // basic info
            $table->string('ewu_id_no')->unique();
            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('nid')->nullable()->unique();
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('blood_group')->nullable();
            $table->longText('about')->nullable();

            // contact info
            $table->string('personal_email')->nullable();
            $table->string('university_email')->nullable();
            $table->string('company_email')->nullable();
            $table->string('personal_contact_number')->nullable()->unique();
            $table->string('official_contact_number')->nullable()->unique();
            $table->string('facebook_profile_link')->nullable();
            $table->string('linkedin_profile_link')->nullable();

            // address info
            $table->string('country_id')->nullable();
            $table->string('division_id')->nullable();
            $table->string('district_id')->nullable();

            // education info
            $table->string('department_id')->nullable();
            $table->string('department_name')->nullable();
            $table->string('program_id')->nullable();
            $table->string('program_type')->nullable();
            $table->string('program_name')->nullable();
            $table->string('passing_year')->nullable();
            $table->string('passing_semester')->nullable();
            $table->string('convocation_year')->nullable();

            // professional info
            $table->string('organization')->nullable();
            $table->string('designation_department')->nullable();
            $table->string('occupation')->nullable();
            $table->string('doj')->nullable();
            $table->string('experience')->nullable();
            $table->string('industry')->nullable();

            // others info
            $table->integer('presentation_skill_rating')->default(0);
            $table->integer('english_skill_rating')->default(0);
            $table->integer('communication_skill_rating')->default(0);
            $table->enum('block_status', ['Block', 'Unblock'])->default('Unblock');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->boolean('is_feature')->default(0);
            $table->enum('reg_type', ['Autometic', 'Manual'])->default('Autometic');
            $table->enum('reg_status', ['Pending', 'Approve', 'Reject'])->default('Approve');
            $table->text('approve_remark')->nullable();
            $table->text('reject_remark')->nullable();
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
        Schema::dropIfExists('alumnis');
    }
};
