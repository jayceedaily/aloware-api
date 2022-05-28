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
        Schema::create('user_followers', function (Blueprint $table) {

            $table->foreignId('follower_id');

            $table->foreign('follower_id')
                    ->references('id')
                    ->on('users');

            $table->foreignId('following_id');

            $table->foreign('following_id')
                    ->references('id')
                    ->on('users');

            $table->primary(['follower_id', 'following_id']);

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
        Schema::dropIfExists('connections');
    }
};
