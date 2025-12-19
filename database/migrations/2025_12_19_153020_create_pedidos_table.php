<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Necesito registrar pedidos especiales: qué material, cantidad, nombre del
// cliente, teléfono, y estado: pedido a proveedor, en camino, llegó, entregado.
// La fecha del pedido que se ponga sola. Si me equivoco, poder corregir. Los
// entregados
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            //Nombres del cliente y apellido
            $table->string('cli_nombre');
            $table->string('cli_apellido');
            //Teléfono
            $table->string('telefono');
            //Material y cantidad
            $table->string('material');
            $table->integer('cantidad');
            //Estado del pedido listado arriba 
            $table->enum('estado', ['pedido_a_proveedor', 'en_camino', 'llego', 'entregado'])->default('pedido_a_proveedor');
            //Fecha del pedido
            $table->timestamp('fecha_pedido')->useCurrent();
            //Fecha de entrega cuando el estado sea entregado, le ponemos null y en caso de que edite un pedido entregado
            //se borre la fecha
            $table->timestamp('fecha_entrega')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
