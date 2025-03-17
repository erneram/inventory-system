@dump($salesDetails)
<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl text-white font-bold mb-6">Detalle de ventas</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success')}}
            </div>
        @endif
        <x-reusable-table
            :headers="['ID', 'Venta Id', 'Producto', 'Cantidad', 'Precio por unidad']"
            :rows="$salesDetails->map(function ($detail) {
            return [
                $detail->id,
                $detail->sale_id,
                $detail->product->name,
                $detail->quantity,
                $detail->unit_price,
            ];
             })->toArray()"
        />
    </div>

    <div class="container mx-auto py-8 mt-10">
        <h2 class="text-xl text-white font-bold mb-4">Nueva venta</h2>
        <form action="{{ route('sales-details.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
            @csrf
            <div class="grid grid-cols-2 gap-2">
                <div class="">
                    <label for="quantity" class="block text-gray-700">Cantidad</label>
                    <input type="number" name="quantity" id="quantity" required
                        class="w-full border px-3 py-2 rounded">
                </div>
                <div class="">
                    <label for="user_id" class="block text-gray-700">Usuario</label>
                    <select name="user_id" id="user_id">
                        @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->id}} - {{$user->name}} - {{$user->role}}</option>
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
                <button type="submit" class="col-span-2 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Añadir
                    Nueva Venta
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
