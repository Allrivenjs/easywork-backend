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
        Schema::create('accept_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\task::class)->constrained();
            $table->foreignIdFor(\App\Models\User::class)->constrained();
            $table->float('charge');
            $table->timestamp('remove_at')->nullable();
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
        Schema::dropIfExists('accept_tasks');
    }
};
