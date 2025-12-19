<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pedidos</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="max-w-6xl mx-auto p-4">

        <h1 class="text-3xl font-bold text-center mb-2">
            Ferretería <span class="text-blue-600">"El Tornillo"</span>
        </h1>

        <h2 class="text-xl text-center mb-6">
            Pedidos en proceso
        </h2>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 flex gap-2 justify-center sm:justify-start">
            <a href="{{ route('pedidos.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded">
                Nuevo pedido
            </a>

            <a href="{{ route('pedidos.lista') }}"
               class="bg-gray-300 px-4 py-2 rounded">
                Lista completa
            </a>
        </div>

        @if($pedidos->isEmpty())
            <p class="text-center sm:text-left">No hay pedidos en proceso.</p>
        @else
            <div class="overflow-x-auto bg-white border rounded">
                <table class="min-w-[1000px] w-full">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border p-2">ID</th>
                            <th class="border p-2">Cliente</th>
                            <th class="border p-2">Teléfono</th>
                            <th class="border p-2">Material</th>
                            <th class="border p-2">Cantidad</th>
                            <th class="border p-2">Estado</th>
                            <th class="border p-2">Fecha pedido</th>
                            <th class="border p-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedidos as $pedido)
                            <tr>
                                <td class="border p-2">{{ $pedido->id }}</td>

                                <td class="border p-2">
                                    {{ $pedido->cli_nombre }} {{ $pedido->cli_apellido }}
                                </td>

                                <td class="border p-2">{{ $pedido->telefono }}</td>
                                <td class="border p-2">{{ $pedido->material }}</td>
                                <td class="border p-2">{{ $pedido->cantidad }}</td>
                                <td class="border p-2">{{ $pedido->estado }}</td>

                                <td class="border p-2">
                                    {{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y H:i') }}
                                </td>

                                <td class="border p-2 whitespace-nowrap">
                                    <a href="{{ route('pedidos.edit', $pedido) }}"
                                       class="text-blue-600 mr-2">
                                        Editar
                                    </a>

                                    <form action="{{ route('pedidos.eliminar', $pedido) }}"
                                          method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                                onclick="return confirm('¿Marcar como entregado?');"
                                                class="text-green-600">
                                            Entregar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <p class="text-xs text-gray-500 mt-2 md:hidden">
                Desliza la tabla hacia los lados para ver todas las columnas.
            </p>
        @endif

    </div>
</body>
</html>
