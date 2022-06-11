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
        Schema::create('user_type_profiles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('profile');
            $table->foreign('profile')->references('id')->on('profiles')->onDelete('cascade');

            $table->unsignedBigInteger('type_user');
            $table->foreign('type_user')->references('id')->on('user_types')->onDelete('cascade');


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
        Schema::dropIfExists('user_type_profiles');
    }
};
