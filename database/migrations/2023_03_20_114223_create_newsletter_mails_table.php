<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('newsletter_mails', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('mail_subject');
            $table->string('recipient_user_ids')->nullable();
            $table->string('selected_mail_list_id')->nullable();
            $table->string('recipient_mails')->nullable();
            $table->string('mail_body');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('newsletter_mails');
    }
};
