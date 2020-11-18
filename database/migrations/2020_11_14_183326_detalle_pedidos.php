<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetallePedidos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('detalle_pedidos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
             // Producto asociado
            $table->integer('producto_id')->unsigned();
            $table->foreign('producto_id')->references('id')->on('productos');
            // Usuario asociado
            $table->integer('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users');
            // Cinoribante asociado : NULLABLE
            $table->integer('pedido_id')->unsigned()->nullable();
            $table->foreign('pedido_id')->references('id')->on('carts');
            
            $table->string('descripcion');            
            $table->DateTime('fecha')->default(date("Y-m-d H:i:s"));
            // Tasa de IVA
            $table->integer('tasa_iva_id')->unsigned()->default(1);
            $table->foreign('tasa_iva_id')->references('id')->on('tasas_iva');

            $table->double('precioUnitario')->nullable();
            $table->integer('cantidad');

            $table->double('subTotal')->nullable();
            $table->double('iva')->nullable();
            $table->double('total')->nullable();
            $table->string('status')->nullable();
            $table->string('orden_pedido')->nullable();
            $table->index(['fecha']);

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
        Schema::dropIfExists('detalle_pedidos');
    }
}

