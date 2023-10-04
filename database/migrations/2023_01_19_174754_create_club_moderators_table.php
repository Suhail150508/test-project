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
        Schema::create('club_moderators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained();
            $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete();
            $table->foreignId('designation_id')->constrained('designations')->cascadeOnDelete();
            $table->string('type')->nullable();
            $table->string('name');
            $table->string('year_from')->nullable();
            $table->string('year_to')->nullable();
            $table->enum('status',['Active','Inactive'])->default('Inactive');
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
        Schema::dropIfExists('club_moderators');
    }
};
