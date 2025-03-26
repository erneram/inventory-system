@props([
    'modalId' => 'createInventoryMovementModal',
    'products' => [],
    'users' => [],
])
<div x-data="createInventoryMovementModalData('{{ $modalId }}')" x-on:open-modal.window="handleOpenModal($event.detail)" x-on:close-modal="open = false"
    x-cloak>
    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black opacity-50"
            @click="$dispatch('close-modal', { name: '{{ $modalId }}' })"></div>
        <div class="bg-white rounded-lg shadow-lg p-6 relative z-10 w-full max-w-md"
            x-on:keydown.escape.window="$dispatch('close-modal', { name: '{{ $modalId }}' })">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold" x-text="createEditInventoryMovementTitle"></h2>
                <button @click="$dispatch('close-modal', { name: '{{ $modalId }}' })">
                    <!-- Close Icon -->
                </button>
            </div>
            <form :action="isEdit ? `/inventory-movements/${id}` : route('categories.store')" method="POST"
                class="mt-4 w-full">
                @csrf
                <template x-if="isEdit">
                    @method('PUT')
                </template>
                <div class="grid grid-cols-2 gap-2">
                    <div class="mb-4 col-span-2">
                        <label for="product_id" class="block text-gray-700">Producto</label>
                        <select name="product_id" id="product_id" x-model="product_id" class="w-full">
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4 col-span-2">
                        <label for="user_id" class="block text-gray-700">Usuario</label>
                        <select name="user_id" id="user_id" x-model="user_id" class="w-full">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Movimiento</label>
                        <input type="text" name="movement_type" required x-model="movement_type"
                            class="w-full border px-3 py-2 rounded">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Cantidad</label>
                        <input type="number" name="quantity" required x-model="quantity"
                            class="w-full border px-3 py-2 rounded">
                    </div>
                </div>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 w-full"
                    x-text="isEdit ? 'Actualizar movimiento' : 'Agregar movimiento'"></button>
            </form>
        </div>
    </div>
</div>

<script>
    function createInventoryMovementModalData(modalId) {
        return {
            open: false,
            isEdit: false,
            id: '',
            product_name: '',
            product_id: '',
            user_name: '',
            user_id: '',
            movement_type: '',
            quantity: '',
            createEditInventoryMovementTitle: '',
            products: @json($products),
            users: @json($users),
            handleOpenModal(detail) {
                if (detail.modalId === modalId) {
                    this.open = true;
                    console.log(detail)
                    if (detail.movement) {
                        this.createEditInventoryMovementTitle = 'Actualizar Movimiento';
                        this.isEdit = true;
                        this.id = detail.movement.id;
                        this.product_name = detail.movement.products;
                        this.product_id = this.products.find((p) => p.name === this.product_name).id;
                        this.user_name = detail.movement.user;
                        this.user_id = this.users.find((u) => u.name === this.user_name) ? this.users.find((u) => u
                            .name === this.user_name).id : this.users[0]
                        this.movement_type = detail.movement.type;
                        this.quantity = detail.movement.quantity;
                    } else {
                        this.createEditInventoryMovementTitle = 'Agregar Movimiento';
                        this.isEdit = false;
                        this.id = '';
                        this.product_name = '';
                        this.product_id = '';
                        this.user_name = '';
                        this.user_id = '';
                        this.movement_type = '';
                        this.quantity = '';
                    }
                }
            }
        };
    }
</script>
