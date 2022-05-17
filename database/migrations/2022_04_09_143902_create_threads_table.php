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
        Schema::create('threads', function (Blueprint $table) {

            $table->id();

            $table->longText('body')->nullable();

            $table->timestamps();

            // Author
            $table->foreignId('created_by');

            $table->foreign('created_by')
                    ->references('id')
                    ->on('users');

            // Reply
            $table->foreignId('parent_id')->nullable();

            $table->foreign('parent_id')
                    ->references('id')
                    ->on('threads');

            // Share
            $table->foreignId('child_id')->nullable();

            $table->foreign('child_id')
                    ->references('id')
                    ->on('threads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('threads');
    }
};
