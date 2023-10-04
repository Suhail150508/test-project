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
        Schema::create('employment_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->nullable()->constrained('resumes')->onDelete('cascade');
            $table->string('company_name');
            $table->string('company_business');
            $table->string('designation');
            $table->string('department');
            $table->date('start_date');
            $table->string('todate');
            $table->text('responsibilities');
            $table->string('skill_ids');
            $table->integer('duration');
            $table->string('job_location');
            $table->timestamps();
        }
            );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employment_histories');
    }
};
