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
        Schema::create('student_feedback', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('student_id')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email_address')->nullable();
            $table->string('degree_program')->nullable();
            $table->string('level_of_study')->nullable();
            $table->longText('question_one')->nullable();
            $table->longText('question_two')->nullable();
            $table->longText('question_three')->nullable();
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
        Schema::dropIfExists('student_feedback');
    }
};
