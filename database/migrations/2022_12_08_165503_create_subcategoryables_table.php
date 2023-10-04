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
        Schema::create('subcategoryables', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("sub_category_id");
            $table->bigInteger("subcategoryable_id");
            $table->string("subcategoryable_type");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcategoryables');
    }
};
