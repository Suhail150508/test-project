<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('specializations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->nullable()->constrained('resumes')->onDelete('cascade');
            $table->string('skill_ids');
            $table->string('learned');
            $table->text('description')->nallable();
            $table->text('extracurricular')->nallable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('specializations');
    }
};
