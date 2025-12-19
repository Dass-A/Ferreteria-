<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar pedido</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="max-w-md mx-auto p-4">

        <h1 class="text-3xl font-bold text-center mb-2">
            Ferretería <span class="text-blue-600">"El Tornillo"</span>
        </h1>

        <h2 class="text-xl text-center mb-6">
            Editar pedido
        </h2>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pedidos.update', $pedido) }}" method="POST"
              class="bg-white p-4 rounded shadow space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium">Nombre</label>
                <input type="text" name="cli_nombre"
                       value="{{ old('cli_nombre', $pedido->cli_nombre) }}"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm font-medium">Apellido</label>
                <input type="text" name="cli_apellido"
                       value="{{ old('cli_apellido', $pedido->cli_apellido) }}"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm font-medium">Teléfono</label>
                <input type="text" name="telefono"
                       value="{{ old('telefono', $pedido->telefono) }}"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm font-medium">Material</label>
                <input type="text" name="material"
                       value="{{ old('material', $pedido->material) }}"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm font-medium">Cantidad</label>
                <input type="number" name="cantidad" min="1"
                       value="{{ old('cantidad', $pedido->cantidad) }}"
                       class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm font-medium">Estado</label>
                <select name="estado" class="w-full border rounded p-2">
                    <option value="pedido_a_proveedor" @selected(old('estado', $pedido->estado) === 'pedido_a_proveedor')>
                        Pedido a proveedor
                    </option>
                    <option value="en_camino" @selected(old('estado', $pedido->estado) === 'en_camino')>
                        En camino
                    </option>
                    <option value="llego" @selected(old('estado', $pedido->estado) === 'llego')>
                        Llegó
                    </option>
                    <option value="entregado" @selected(old('estado', $pedido->estado) === 'entregado')>
                        Entregado
                    </option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 rounded">
                    Guardar cambios
                </button>

                <a href="{{ route('pedidos.index') }}"
                   class="w-full text-center bg-gray-300 py-2 rounded">
                    Volver
                </a>
            </div>
        </form>

    </div>
</body>
</html>
