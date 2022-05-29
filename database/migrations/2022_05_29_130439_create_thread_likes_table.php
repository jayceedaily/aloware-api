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
        Schema::create('thread_likes', function (Blueprint $table) {
            $table->foreignId('user_id');

            $table->foreign('user_id')
                    ->references('id')
                    ->on('users');

            $table->foreignId('thread_id');

            $table->foreign('thread_id')
                    ->references('id')
                    ->on('threads');

            $table->primary(['user_id', 'thread_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thread_likes');
    }
};
