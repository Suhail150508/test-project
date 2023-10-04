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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('user_type')->nullable();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->dateTime('start_date_time')->nullable();
            $table->dateTime('end_date_time')->nullable();
            $table->longText('description')->nullable();
            $table->string('speakers')->nullable();
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
        Schema::dropIfExists('events');
    }
};
