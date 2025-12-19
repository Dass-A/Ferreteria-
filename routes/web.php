<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController;

Route::get('/', function () {
    return redirect()->route('pedidos.index');
});

Route::prefix('pedidos')->controller(PedidoController::class)
    ->group(function () {

        // Mostrar pedidos
        Route::get('/', 'index')->name('pedidos.index');

        // Mostrar todos los pedidos entregados y los que siguen en proceso
        Route::get('/lista', 'lista')->name('pedidos.lista');

        // Mostrar formulario para crear un nuevo registro
        Route::get('/create', 'create')->name('pedidos.create');
        
        // Guardar nuevo registro
        Route::post('/', 'store')->name('pedidos.store');

        // Editar un registro
        Route::get('/edit/{pedido}', 'edit')->name('pedidos.edit');

        // Actualizar un registro
        Route::put('/update/{pedido}', 'update')->name('pedidos.update');

        // Eliminar un registro
        Route::put('/eliminar/{pedido}', 'eliminar')->name('pedidos.eliminar');
    });
