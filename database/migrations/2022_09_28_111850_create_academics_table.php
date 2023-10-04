<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('academics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_seeker_id')->constrained();
            $table->enum('degree_name', ['SSC', 'HSC','UnderGraduation','PostGraduation','PhD']);
            $table->string('institution_name');
            $table->integer('passing_year');
            $table->string('passing_semester')->nullable();
            $table->string('group_or_subject')->nullable();
            $table->integer('gpa')->nullable();
            $table->integer('c_gpa')->nullable();
            $table->integer('gpa_out_of')->nullable();
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
        Schema::dropIfExists('academics');
    }
};
