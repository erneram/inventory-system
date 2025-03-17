<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold text-white mb-6">Movimientos de inventario</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success')}}
            </div>
        @endif

        <x-reusable-table
            :headers="['Id', 'Productos', 'Usuario', 'Tipo de movimiento', 'Cantidad']"
            :rows="$inventoryMovement->map(function($movement) {
                return [
                    $movement->id,
                    $movement->product->name,
                    $movement->user->name,
                    $movement->movement_type,
                    $movement->quantity
                ];
            })->toArray()"
        />
    </div>
</x-app-layout>
