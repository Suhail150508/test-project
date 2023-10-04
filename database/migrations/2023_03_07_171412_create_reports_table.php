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
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->foreignId('sender_id')->nullable()->constrained('users');
            // $table->foreignId('recipient_id')->nullable()->constrained('users');
            $table->foreignId('sender_id')->nullable()->constrained('alumnis');
            $table->foreignId('recipient_id')->nullable()->constrained('alumnis');
            $table->string('attribute');
            $table->string('attribute_id');
            $table->foreignId('report_type_id')->nullable()->constrained();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('reports');
    }
};
