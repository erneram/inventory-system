@props([
    'modalId' => 'createSaleModal',
    'users' => [],
])
<div x-data="createEditSaleModalData('{{ $modalId }}')" x-on:open-modal.window="handleOpenModal($event.detail)" x-on:close-modal.window="open = false"
    x-cloak>
    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black opacity-50"
            @click="$dispatch('close-modal', { name: '{{ $modalId }}' })"></div>
        <div class="bg-white rounded-lg shadow-lg p-6 relative z-10 w-full max-w-md"
            x-on:keydown.escape.window="$dispatch('close-modal', { name: '{{ $modalId }}' })">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold" x-text="createEditSaleTitle"></h2>
                <button @click="$dispatch('close-modal', { name: '{{ $modalId }}' })">
                </button>
            </div>
            <form :action="isEdit ? `/sales/${id}` : route('sales.store')" method="POST" class="mt-4 w-full">
                @csrf
                <template x-if="isEdit">
                    @method('PUT')
                </template>
                <div class="grid grid-cols-2 gap-2">
                    <div class="mb-4 col-span-2">
                        <label for="total_price" class="block text-gray-700">Precio total</label>
                        <input type="numeric" name="total_price" x-model="total_price" required
                            class="w-full border px-3 py-2 rounded">
                    </div>
                    <div class="mb-4 col-span-2">
                        <label for="user_id" class="block text-gray-700">Usuarios</label>
                        <select name="user_id" x-model="user_id" class="w-full">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit"
                        class="col-span-2 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700"
                        x-text="isEdit ? 'Modificar venta' : 'Añadir venta'"></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function createEditSaleModalData(modalId) {
        return {
            open: false,
            isEdit: false,
            createEditSaleTitle: '',
            user_name: '',
            user_id: '',
            total_price: '',
            id: '',
            users: @json($users),
            handleOpenModal(detail) {
                if (detail.modalId === modalId) {
                    this.open = true;
                    if (detail.sales) {
                        this.isEdit = true;
                        this.createEditSaleTitle = 'Editar venta';
                        this.user_name = detail.sales.user;
                        this.user_id = this.users.find((u) => u.name === this.user_name) ? this.users.find((u) => u
                            .name === this.user_name).id : '0';
                        this.total_price = detail.sales.price;
                        this.id = detail.sales.id;
                    } else {
                        this.isEdit = false;
                        this.createEditSaleTitle = 'Añadir nueva venta';
                        this.user_name = null;
                        this.user_id = '';
                        this.total_price = '';
                        this.id = '';
                    }
                }
            }
        };
    }
</script>
