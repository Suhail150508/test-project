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
        Schema::create('job_interested_areas', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('resume_id')->nullable()->constrained('resumes')->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('job_category_ids')->nullable(); //professional interest
            $table->string('personal_interest')->nullable();
            $table->string('job_area_districts')->nullable(); //job interested area
            $table->string('organization_types')->nullable();
            $table->enum('status', ['Active', 'Inactive']);
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
        Schema::dropIfExists('job_interested_areas');
    }
};
