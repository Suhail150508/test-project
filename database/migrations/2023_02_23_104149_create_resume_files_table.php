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
        Schema::create('resume_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->nullable()->constrained('resumes')->onDelete('cascade');
            $table->string('resume_cv')->nullable();
            $table->string('resume_video')->nullable();
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
        Schema::dropIfExists('resume_files');
    }
};
