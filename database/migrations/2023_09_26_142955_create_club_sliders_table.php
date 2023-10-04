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
        Schema::create('club_sliders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->nullable()->constrained('clubs')->cascadeOnDelete();
            $table->text('title')->nullable();
            $table->text('sub_title')->nullable();
            $table->longText('description')->nullable();
            $table->string('url')->nullable();
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
        Schema::dropIfExists('club_sliders');
    }
};
