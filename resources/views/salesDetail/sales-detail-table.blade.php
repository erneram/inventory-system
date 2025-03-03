<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl text-white font-bold mb-6">Detalle de ventas</h1>

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
                        <th class="py-3 px-5 text-left text-sm font-semibold text-gray-700">Venta ID</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold text-gray-700">Producto</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold text-gray-700">Cantidad</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold text-gray-700">Precio por unidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($salesDetails as $detail)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-3 px-5 text-sm text-gray-600">{{$detail->id}}</td>
                            <td class="py-3 px-5 text-sm text-gray-600">{{$detail->sales_id}}</td>
                            <td class="py-3 px-5 text-sm text-gray-600">{{$detail->product->name}}</td>
                            <td class="py-3 px-5 text-sm text-gray-600">{{$detail->quantity}}</td>
                            <td class="py-3 px-5 text-sm text-gray-600">{{$detail->unit_price}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- Formulario para agregar categorias --}}
    <div class="mt-10">
        <h2 class="text-xl text-white font-bold mb-4">Agregar Nuevo Detalle de Venta</h2>
        <form action="{{ route('sales-details.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
            @csrf
            <div class="mb-4">
                <label for="quantity" class="block text-gray-700">Cantidad</label>
                <input type="number" name="quantity" id="quantity" required
                    class="w-full border px-3 py-2 rounded">
            </div>
            <div class="mb-4">
                <label for="unit_price" class="block text-gray-700">Precio por unidad</label>
                <input type="number" name="unit_price" id="unit_price" required
                    class="w-full border px-3 py-2 rounded">
            </div>
            <div class="mb-4">
                <label for="sales_id" class="block text-gray-700">Ventas</label>
                <select name="sales_id" id="sales_id">
                    @foreach ($sales as $sale)
                        <option value="{{$sale->id}}">{{$sale->id}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="product_id" class="block text-gray-700">Product</label>
                <select name="product_id" id="product_id">
                    @foreach ($products as $product)
                        <option value="{{$product->id}}">{{$product->name}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Añadir
                Nueva Venta</button>
        </form>
    </div>
</x-app-layout>
