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
        Schema::create('veedores', function (Blueprint $table) {
            $table->id();
            $table->string('dni',10)->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('observacion')->nullable();
            /*Foreign Keys */
            $table->integer('user_id');             /* Registra el usuario quien lo creo */
            $table->integer('parroquia_id');        /* Parroquia donde esta trabajando */
            $table->integer('recinto__id');          /* Recinto donde esta trabajando */ /* tiene doble guion bajo */
            $table->integer('recinto_id');          /* Recinto de donde es originario */ /* Tiene un solo guion bajo */

            /*Campos para guardar imagenes */
            $table->text('imagen_frontal');
            $table->text('imagen_reverso');

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
        Schema::dropIfExists('veedors');
    }
};
