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
        Schema::create('employment_area_of_expertices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employment_history_id')->nullable()->constrained('employment_histories')->onDelete('cascade');
            $table->string('skill_ids');
            $table->integer('Duration');
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
        Schema::dropIfExists('employment_area_of_expertices');
    }
};
