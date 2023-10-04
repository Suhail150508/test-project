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
        Schema::create('training_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->nullable()->constrained('resumes')->onDelete('cascade');
            $table->foreignId('training_id')->nullable()->constrained('trainings')->onDelete('cascade');
            // $table->text('title');
            $table->text('topics_covered');
            $table->integer('training_year');
            $table->string('institute');
            $table->integer('duration');
            $table->string('location');
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
        Schema::dropIfExists('training_summaries');
    }
};
