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
        Schema::create('group_news_feed_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('group_news_feed_fileable', 'group_news_feed_fileable_index');
            $table->string('type')->nullable();
            $table->string('source')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('alumnis');
            $table->foreignId('updated_by')->nullable()->constrained('alumnis');
            $table->foreignId('deleted_by')->nullable()->constrained('alumnis');
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
        Schema::dropIfExists('group_news_feed_files');
    }
};
