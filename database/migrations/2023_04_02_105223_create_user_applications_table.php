<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('user_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('workshop_id')->nullable()->constrained('workshops');
            $table->foreignId('internship_id')->nullable()->constrained('internships');
            $table->foreignId('job_post_id')->nullable()->constrained('job_posts');
            $table->foreignId('training_id')->nullable()->constrained('trainings');
            $table->foreignId('resume_id')->nullable()->constrained('resumes')->onDelete('cascade');
            $table->boolean('withdraw_status')->default(false);
            $table->date('applyed_date')->nullable();
            $table->enum('job_status', ['New', 'Interviewed','Offer Extended','Hired','Archived'])->default('New');
            $table->enum('application_type', ['Job', 'Workshop','Training', 'Internship'])->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->text('withdraw_reson')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_applications');
    }
};
