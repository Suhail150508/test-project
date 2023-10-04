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
        Schema::create('career_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->nullable()->constrained('resumes')->onDelete('cascade');
            $table->longText('brief_profile');
            $table->integer('present_salary');
            $table->integer('expected_salary');
            $table->enum('available_for',['Full Time','Part Time','Contractual','Internship','Freelance'])->default('Full Time');
            $table->enum('looking_for',['Entry Level','Mid Level','Top Level'])->default('Mid Level');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('career_applications');
    }
};
