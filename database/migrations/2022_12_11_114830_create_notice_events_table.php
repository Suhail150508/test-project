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
        Schema::create('notice_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_post_id')->nullable()->constrained('job_posts')->cascadeOnDelete();
            $table->text('title');
            $table->string('slug')->nullable();
            $table->longText('description');
            $table->string('time');
            $table->string('date');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
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
        Schema::dropIfExists('notice_events');
    }
};
