<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl text-white font-bold mb-6">Ventas</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success')}}
            </div>
        @endif

        {{-- TABLA PRECIOS --}}
        <div class="overflox-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-3 px-5 text-left text-sm font-semibold text-gray-700">Id</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold text-gray-700">Usuario</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold text-gray-700">Precio Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-3 px-5 text-sm text-gray-600">{{$sale->id}}</td>
                            <td class="py-3 px-5 text-sm text-gray-600">{{$sale->user->name}}</td>
                            <td class="py-3 px-5 text-sm text-gray-600">{{$sale->total_price}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- Formulario para agregar categorias --}}
    <div class="mt-10">
        <h2 class="text-xl text-white font-bold mb-4">Agregar Nueva Venta</h2>
        <form action="{{ route('sales.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
            @csrf
            <div class="mb-4">
                <label for="total_price" class="block text-gray-700">Precio total</label>
                <input type="number" name="total_price" id="total_price" required
                    class="w-full border px-3 py-2 rounded">
            </div>
            <div class="mb-4">
                <label for="user_id" class="block text-gray-700">Usuarios</label>
                <select name="user_id" id="user_id">
                    @foreach ($users as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Añadir
                Nueva Venta</button>
        </form>
    </div>
</x-app-layout>
