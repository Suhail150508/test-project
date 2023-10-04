<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('company_name')->nullable();
            $table->string('company_name_bn');
            $table->integer('year_of_stablishment')->nullable();
            $table->integer('company_size')->nullable();
            $table->string('industry_type')->nullable();
            $table->string('contact_number')->nullable()->unique();
            $table->string('email')->nullable()->unique();
            $table->foreignId('division_id')->nullable()->constrained();
            $table->foreignId('district_id')->nullable()->constrained();
            $table->foreignId('thana_id')->nullable()->constrained();
            $table->text('business')->nullable();
            $table->text('website_url')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
        // Schema::create('employees', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('designation_id')->nullable()->constrained();
        //     $table->string('name')->nullable();
        //     $table->string('bn_name');
        //     $table->string('father')->nullable();
        //     $table->string('mother')->nullable();
        //     $table->string('old_pin')->unique();
        //     $table->string('new_pin')->nullable()->unique();
        //     $table->enum('religion',['Islam','Hinduism','Christianity','Buddhism','Other Religion'])->nullable();
        //     $table->enum('gender',['Male','Female','Other'])->nullable();
        //     $table->string('id_card')->nullable()->unique();
        //     $table->string('nid')->nullable()->unique();
        //     $table->date('birth_date')->nullable();
        //     $table->string('mobile')->nullable()->unique();
        //     $table->string('email')->nullable()->unique();
        //     $table->string('emergency_contact')->nullable();
        //     $table->text('permanent_address')->nullable();
        //     $table->text('present_address')->nullable();
        //     $table->foreignId('division_id')->nullable()->constrained();
        //     $table->foreignId('district_id')->nullable()->constrained();
        //     $table->foreignId('thana_id')->nullable()->constrained();
        //     $table->text('job_details')->nullable();
        //     $table->enum('status', ['Active', 'Inactive'])->default('Active');
        //     $table->foreignId('created_by')->nullable()->constrained('users');
        //     $table->foreignId('updated_by')->nullable()->constrained('users');
        //     $table->foreignId('deleted_by')->nullable()->constrained('users');
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
