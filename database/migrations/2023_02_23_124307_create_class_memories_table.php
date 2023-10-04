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
        Schema::create('class_memories', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('user_type')->nullable();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->longText('rules')->nullable();
            $table->enum('invite_by_member', ['Yes', 'No'])->nullable();
            $table->enum('review_by_admin', ['Yes', 'No'])->nullable();
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
        Schema::dropIfExists('class_memories');
    }
};
