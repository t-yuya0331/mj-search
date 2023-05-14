<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('target')
                    ->comment('1 beginner 2 intermediate 3 advanced 4 anyone')
                    ->nullable();
            $table->text('description');
            $table->date('date')->nullable();
            $table->time('time');
            $table->string('number')->nullable();
            $table->text('location')->nullable();
            $table->unsignedBigInteger('role_id')
                    ->comment('1 upcoming 2 past')
                    ->default('1');
            $table->unsignedBigInteger('status')
                    ->comment('1opening  2 full')
                    ->default('1');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
