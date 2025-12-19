<?php

namespace App\Http\Controllers;

use App\Models\pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    
    //Validar 
    private function reglasValidacion(): array
{
    return [
        'cli_nombre' => [
            'required',
            'string',
            'max:50',
            'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'
        ],

        'cli_apellido' => [
            'required',
            'string',
            'max:50',
            'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'
        ],

        'telefono' => [
            'required',
            'string',
            'max:20',
            'regex:/^[0-9]+$/'
        ],
        'material' => 'required|string|max:255',
        'cantidad' => 'required|integer|min:1',
        'estado'   => 'required|in:pedido_a_proveedor,en_camino,llego,entregado',
        
    ];

    
    }

    private function mensajesValidacion(): array
    {
        return [
            'cli_nombre.regex' => 'Nombre no válido.',
            'cli_nombre.required' => 'El nombre es obligatorio.',

            'cli_apellido.regex' => 'Apellido no válido.',
            'cli_apellido.required' => 'El apellido es obligatorio.',

            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.regex' => 'El teléfono solo debe contener números.',
            'material.required' => 'El material es obligatorio.',
            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.min' => 'La cantidad debe ser mayor a 0.',
            
    ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = Pedido::where('estado', '!=', 'entregado')
            ->orderByDesc('fecha_pedido')
            ->get();

        return view('pedidos', compact('pedidos'));
    }
    
    //VER TODOS LOS PEDIDOS
    public function lista()
    {
        $pedidos = Pedido::orderByDesc('fecha_pedido')->get();

        return view('pedidoslista', compact('pedidos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
        $this->reglasValidacion(),
        $this->mensajesValidacion()
        );

        Pedido::create($validatedData);

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    // public function show(pedido $pedidos)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        return view('edit', compact('pedido'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        $data = $request->validate($this->reglasValidacion());

        //Comparación de estados par ver si quito o no la fehca de entrega
        $estadoAnterior = $pedido->estado;
        $nuevoEstado    = $data['estado'];

        // En caso de que sí hubo cambio de entregado y era diferente se setea la fecha 
        if ($nuevoEstado === 'entregado' && $estadoAnterior !== 'entregado') {
            $data['fecha_entrega'] = now();
        }

        // Si pasa de entregado a otro estado se quita la fecha
        if ($estadoAnterior === 'entregado' && $nuevoEstado !== 'entregado') {
            $data['fecha_entrega'] = null;
        }

        $pedido->update($data);

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function eliminar(Pedido $pedido)
    {
        // Si no esta entregado se lo setea como entregado
        if ($pedido->estado !== 'entregado') {
            $pedido->estado = 'entregado';
            $pedido->fecha_entrega = now();
            $pedido->save();
        }
        //Pongo como mensaje que se entrego el pedido y con la recarga ya sale de la vista
        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido entregado.');
    }
}
