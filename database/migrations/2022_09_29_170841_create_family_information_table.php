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
        Schema::create('family_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_seeker_id')->constrained();
            $table->string('relation');
            $table->string('full_name');
            $table->string('occupation');
            $table->string('organization')->nullable();
            $table->string('designation')->nullable();
            $table->string('phone')->nullable();
            $table->longText('present_address')->nullable();
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
        Schema::dropIfExists('family_information');
    }
};
