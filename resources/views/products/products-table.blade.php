

<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl text-white font-bold mb-6">Productos</h1>

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
                        <th class="py-3 px-5 text-left text-sm font-semibold text-gray-700">Nombre</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold text-gray-700">Descripción</th>
                        <th class="py-3 px-5 text-left text-sm font-semibold text-gray-700">Categoría</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-3 px-5 text-sm text-gray-600">{{$product->id}}</td>
                            <td class="py-3 px-5 text-sm text-gray-600">{{$product->name}}</td>
                            <td class="py-3 px-5 text-sm text-gray-600">{{$product->description}}</td>
                            <td class="py-3 px-5 text-sm text-gray-600">{{$product->category->name}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- Formulario para agregar categorias --}}
    <div class="mt-10">
        <h2 class="text-xl text-white font-bold mb-4">Agregar Nueva Categoría</h2>
        <form action="{{ route('products.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nombre</label>
                <input type="text" name="name" id="name" required class="w-full border px-3 py-2 rounded">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Descripción</label>
                <textarea name="description" id="description" class="w-full border px-3 py-2 rounded"></textarea>
            </div>
            {{-- <div class="mb-4">
                <label for="price" class="block text-gray-700">Precio</label>
                <input type="number" name="price" id="price" required class="w-full border px-3 py-2 rounded">
            </div> --}}
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700">Categorias</label>
                <select name="categories_id" id="category_id">
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Añadir
                Producto</button>
        </form>
    </div>
</x-app-layout>
