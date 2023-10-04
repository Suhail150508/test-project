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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('resume_id')->nullable()->constrained('resumes')->onDelete('cascade');
            $table->foreignId('job_seeker_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('job_post_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('alumni_id')->nullable()->constrained('alumnis')->onDelete('cascade');
            $table->foreignId('student_id')->nullable()->constrained('students')->onDelete('cascade');
            $table->foreignId('company_detail_id')->nullable()->constrained('company_details')->onDelete('cascade');
            $table->enum('type',['present','permanent'])->default('present');
            // $table->foreignId('country_id')->nullable()->constrained();
            $table->foreignId('division_id')->nullable()->constrained('divisions');
            $table->foreignId('district_id')->constrained('districts');
            $table->foreignId('thana_id')->nullable()->constrained('thanas');
            $table->string('area');
            $table->string('road_no')->nullable();
            $table->string('house_no')->nullable();
            $table->enum('is_permanent',['yes','no'])->default('no');
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
        Schema::dropIfExists('addresses');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
