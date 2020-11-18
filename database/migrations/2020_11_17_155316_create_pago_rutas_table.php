<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagoRutasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_rutas', function (Blueprint $table) {
            $table->increments('id');
            // FK header
            $table->integer('cart_id')->unsigned();
            $table->foreign('cart_id')->references('id')->on('carts');

            // FK product
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('productos');
            
            // FK user para conocer los pedidos que ha realizado
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            
            // FK user para conocer los pedidos que ha realizado
            $table->integer('tipo_pago_id')->unsigned();
            $table->foreign('tipo_pago_id')->references('id')->on('tipo_pagos');


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
        Schema::dropIfExists('pago_rutas');
    }
}
