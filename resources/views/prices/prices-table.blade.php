<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl text-white font-bold mb-6">Precios</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success')}}
            </div>
        @endif
        <x-reusable-table
            :headers="['ID', 'Producto', 'Precio', 'Precio Venta']"
            :rows="$prices->map(function($price) {
                return [
                    $price->id,
                    $price->product->name,
                    $price->cost_price,
                    $price->selling_price
                ];
            })->toArray()"
        />
    </div>
    {{-- Formulario para agregar categorias --}}
    <div class="mt-10">
        <h2 class="text-xl text-white font-bold mb-4">Agregar Nueva Categoría</h2>
        <form action="{{ route('prices.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
            @csrf
            <div class="mb-4">
                <label for="cost_price" class="block text-gray-700">Precio del producto</label>
                <input type="number" name="cost_price" id="selling_price" required class="w-full border px-3 py-2 rounded">
            </div>
            <div class="mb-4">
                <label for="selling_price" class="block text-gray-700">Precio de venta</label>
                <input type="number" name="selling_price" id="selling_price" required class="w-full border px-3 py-2 rounded">
            </div>
            <div class="mb-4">
                <label for="product_id" class="block text-gray-700">Categorias</label>
                <select name="product_id" id="product_id">
                    @foreach ($products as $product)
                        <option value="{{$product->id}}">{{$product->name}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Añadir
                Producto</button>
        </form>
    </div>
</x-app-layout>
