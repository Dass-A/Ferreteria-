<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista completa de pedidos</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="max-w-6xl mx-auto p-4">

        <h1 class="text-3xl font-bold text-center mb-2">
            Ferretería <span class="text-blue-600">"El Tornillo"</span>
        </h1>

        <h2 class="text-xl text-center mb-6">
            Lista completa de pedidos
        </h2>

        <div class="mb-4 flex justify-center sm:justify-start">
            <a href="{{ route('pedidos.index') }}"
               class="bg-gray-300 px-4 py-2 rounded">
                Volver a pedidos
            </a>
        </div>

        @if($pedidos->isEmpty())
            <p class="text-center">No hay pedidos registrados.</p>
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
                            <th class="border p-2">Fecha entrega</th>
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
                                    {{ $pedido->fecha_pedido }}
                                </td>

                                <td class="border p-2">
                                    {{ $pedido->fecha_entrega ?? '-' }}
                                </td>

                                <td class="border p-2">
                                    <a href="{{ route('pedidos.edit', $pedido) }}"
                                       class="text-blue-600">
                                        Editar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <p class="text-xs text-gray-500 mt-2 md:hidden">
                Desliza la tabla para ver todas las columnas.
            </p>
        @endif

    </div>
</body>
</html>
