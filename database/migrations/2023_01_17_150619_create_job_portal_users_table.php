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
        Schema::create('job_portal_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('blood_group')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('username')->unique();
            $table->string('mobile')->nullable()->unique();
            $table->string('phone_no')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nid')->nullable()->unique();
            $table->string('address')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Others'])->nullable();
            $table->string('ewu_id_no')->nullable();
            $table->enum('employment_status',['General','Student','Alumni','Admin','Company'])->default('General');
            $table->enum('status', ['Active', 'Inactive'])->default('Inactive');
            // $table->enum('permission_as_role', ['Yes', 'No'])->default('Yes');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->rememberToken();
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
        Schema::dropIfExists('job_portal_users');
    }
};
