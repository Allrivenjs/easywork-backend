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
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->timestamps();
        });

        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->enum('difficulty',['easy','easy-medium','medium','medium-hard','hard']);


            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');

            $table->unsignedBigInteger('own_id');
            $table->foreign('own_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('task_topic', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('topic_id')->nullable();
            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');

            $table->unsignedBigInteger('task_id')->nullable();
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('profile_topic', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\profile::class)->constrained();
            $table->foreignIdFor(\App\Models\topic::class)->constrained();

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
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('statuses');
        Schema::dropIfExists('topics');
        Schema::dropIfExists('topics_tasks');

    }
};
