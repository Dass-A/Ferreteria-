<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pedido extends Model
{
    protected $table = 'pedidos';

    protected $fillable = [
        'cli_nombre',
        'cli_apellido',
        'telefono',
        'material',
        'cantidad',
        'estado',
        'fecha_pedido',
        'fecha_entrega',
    ];

}
