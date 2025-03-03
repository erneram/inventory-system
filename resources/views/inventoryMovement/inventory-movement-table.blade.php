<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Movimientos de inventario</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success')}}
            </div>
        @endif

        {{-- TABLA CATEGORIAS --}}
        <div class="overflox-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-3 px-5 text-left text-sm font-semibold text-gray-700">Id</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold text-gray-700">Producto</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold text-gray-700">Usuario</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold text-gray-700">Tipo de movimiento</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold text-gray-700">Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventoryMovement as $movement)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-3 px-5 text-sm text-gray-600">{{$movement->id}}</td>
                            <td class="py-3 px-5 text-sm text-gray-600">{{$movement->product->name}}</td>
                            <td class="py-3 px-5 text-sm text-gray-600">{{$movement->user->name}}</td>
                            <td class="py-3 px-5 text-sm text-gray-600">{{$movement->movement_type}}</td>
                            <td class="py-3 px-5 text-sm text-gray-600">{{$movement->quantity}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- Formulario para agregar categorias --}}
    <div class="mt-10">
        <h2 class="text-xl font-bold mb-4">Agregar Nueva Categoría</h2>
        <form action="{{ route('inventory-movements.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nombre</label>
                <input type="text" name="name" id="name" required class="w-full border px-3 py-2 rounded">
            </div>
            <div class="mb-4">
                <label for="type" class="block text-gray-700">Tipo</label>
                <input type="text" name="type" id="type" required class="w-full border px-3 py-2 rounded">
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Agregar
                Categoría</button>
        </form>
    </div>
</x-app-layout>
