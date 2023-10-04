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
        Schema::create('news_feeds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('alumni_id')->unsigned()->constrained()->onDelete('cascade');

            $table->string('title')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->text('body')->nullable();

            $table->integer('view_count')->default(0);
            $table->integer('like_count')->default(0);
            $table->integer('comment_count')->default(0);

            $table->boolean('status')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->datetime('posted_at')->nullable();

            $table->enum('visibility', ['anyone', 'connections', 'only_me'])->default('anyone');
            $table->enum('comment_permission', ['anyone', 'connections', 'only_me'])->default('anyone');

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
        Schema::dropIfExists('news_feeds');
    }
};
