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
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('short_name')->unique();
            $table->longText('description');
            $table->longText('about');
            $table->string('c_address');
            $table->string('c_email');
            $table->string('c_phone')->nullable();
            $table->string('c_room_no')->nullable();
            $table->longText('c_description')->nullable();
            $table->string('slug')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Inactive');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
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
        Schema::dropIfExists('clubs');
    }
};
