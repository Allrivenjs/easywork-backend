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
        Schema::create('tarjetas', function (Blueprint $table) {
            $table->id();
            $table->string('type_tarjeta');
            $table->string('numero_tarjeta');
            $table->string('fecha_tarjeta');
            $table->string('estado_tarjeta');
            $table->string('cvv_tarjeta');
            $table->foreignIdFor(\App\Models\User::class)->constrained();
            $table->json('detalles_tarjeta');
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
        Schema::dropIfExists('tarjetas');
    }
};
