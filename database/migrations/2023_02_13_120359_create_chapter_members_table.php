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
        Schema::create('chapter_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('chapter_id')->constrained('chapters')->onDelete('cascade');
            $table->foreignId('alumni_id')->constrained('alumnis')->onDelete('cascade');
            $table->enum('status', ['pending', 'accept', 'reject'])->default('pending')->comment('pending/accept/reject');
            $table->enum('role', ['creator','admin', 'moderator', 'member'])->default('member')->comment('creator/admin/moderator/member');
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
        Schema::dropIfExists('chapter_members');
    }
};
