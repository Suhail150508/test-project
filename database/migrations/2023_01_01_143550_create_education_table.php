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
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->foreignId('resume_id')->nullable()->constrained('resumes')->onDelete('cascade');
            $table->string('user_type')->nullable();
            $table->enum('type',['jsc','ssc','hsc','graduation','masters','more'])->nullable();
            $table->string('degree')->nullable();   //examination
            $table->string('field_of_study')->nullable();   //subject
            $table->string('school')->nullable();   //institution
            $table->string('grade')->nullable();    //result

            $table->string('board')->nullable();
            $table->string('roll')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('duration')->nullable();
            $table->string('passing_year')->nullable();
            $table->foreignId('major_subject_id')->nullable()->constrained('subjects')->onDelete('cascade');
            $table->foreignId('minor_subject_id')->nullable()->constrained('subjects')->onDelete('cascade');

            //  $table->string('examination')->nullable();
            //  $table->string('result')->nullable();
            //  $table->string('subject')->nullable();
            //  $table->string('institute')->nullable();

            $table->text('activities')->nullable();
            $table->text('description')->nullable();
            $table->enum('is_current', ['Yes', 'No'])->nullable();
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
        Schema::dropIfExists('education');
    }
};
