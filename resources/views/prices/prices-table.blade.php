<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl text-white font-bold mb-6">Precios</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif
        <x-reusable-table :columns="[
            ['field' => 'id', 'name' => 'ID', 'hasAction' => false],
            ['field' => 'product', 'name' => 'Producto', 'hasAction' => false],
            ['field' => 'price', 'name' => 'Precio', 'hasAction' => false],
            ['field' => 'sell_price', 'name' => 'Precio Venta', 'hasAction' => false],
        ]" :rows="$prices
            ->map(function ($price) {
                return [
                    'id' => $price->id,
                    'product' => $price->product ? $price->product->name : 'Sin producto',
                    'price' => $price->cost_price,
                    'sell_price' => $price->selling_price,
                ];
            })
            ->toArray()">

            <x-slot name="rowActions">
                <div class="flex flex-row justify-between">
                    <span x-data @click="$dispatch('open-modal', { modalId: 'createPriceModal', price: row })"
                        class="cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6 text-blue-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                        </svg>
                    </span>
                </div>
            </x-slot>
        </x-reusable-table>

        <x-prices.create-prices-modal modalId="createPriceModal" :products="$products" />
    </div>

</x-app-layout>
