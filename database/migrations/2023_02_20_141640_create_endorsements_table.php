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
        Schema::create('endorsements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_type')->nullable();
            $table->string('user_id');

            $table->string('endorser_type')->nullable();
            $table->string('endorser_id');

            $table->string('activity_type')->nullable();
            $table->string('activity_id');

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
        Schema::dropIfExists('endorsements');
    }
};
