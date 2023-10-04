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
        Schema::create('language_proficiencies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resume_id')->nullable()->constrained('resumes')->onDelete('cascade');
            $table->string('language');
            $table->enum('reading',['High','Medium','Low'])->default('Medium');
            $table->enum('writing',['High','Medium','Low'])->default('Medium');
            $table->enum('speaking',['High','Medium','Low'])->default('Medium');
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
        Schema::dropIfExists('language_proficiencies');
    }
};
