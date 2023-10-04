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
        Schema::create('ccc_updates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('types',['General','Semester wise', 'Annual' ,'Gallery'])->default('General');
            $table->string('title', 2000);
            $table->string('semester_and_year')->nullable();
            $table->string('slug', 2000);
            $table->longText('description')->nullable();
            $table->boolean('published')->default(false);
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
        Schema::dropIfExists('ccc_updates');
    }
};
