<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('role_id')->nullable()->constrained();
            $table->string('name')->nullable();
            $table->string('bn_name')->nullable();
            $table->string('mobile')->nullable()->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('nid')->nullable()->unique();
            $table->date('dob')->nullable();
            $table->longText('address')->nullable();
            $table->enum('is_admin',['Yes','No'])->nullable();
            $table->enum('employment_status',['General', 'Admin', 'Student','Alumni','Job-Seeker','Job-Holder', 'Company','EWU-Staff'])->default('General');
            $table->enum('permission_as_role', ['Yes', 'No'])->default('Yes');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->string('password')->nullable();
            $table->timestamp('last_seen')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
