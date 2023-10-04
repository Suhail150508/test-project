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
        Schema::create('club_committees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_id')->constrained();
            $table->foreignId('department_id')->constrained();
            $table->foreignId('designation_id')->nullable()->constrained();
            $table->string('type')->nullable();
            $table->text('name');
            $table->longText('club_designation')->nullable();
            $table->string('date_from')->nullable();
            $table->string('date_to')->nullable();
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
        Schema::dropIfExists('club_committees');
    }
};
