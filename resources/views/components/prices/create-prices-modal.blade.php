@props([
    'modalId' => 'createPriceModal',
    'products' => [],
])
<div x-data="createPriceModalData('{{ $modalId }}')" x-on:open-modal.window="handleOpenModal($event.detail)" x-on:close-modal.window="open = false"
    x-cloak>
    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black opacity-50"
            @click="$dispatch('close-modal', { name: '{{ $modalId }}' })"></div>
        <div class="bg-white rounded-lg shadow-lg p-6 relative z-10 w-full max-w-md"
            x-on:keydown.escape.window="$dispatch('close-modal', { name: '{{ $modalId }}' })">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold" x-text="createPriceTitle"></h2>
                <button @click="$dispatch('close-modal', { name: '{{ $modalId }}' })">
                </button>
            </div>
            <form :action="`/prices/${id}`" method="POST" class="mt-4 w-full">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-2">
                    <div class="col-span-2">
                        <h2 x-text="product_name" class="text-xl font-bold"></h2>
                    </div>
                    <div class="mb-4">
                        <label for="cost_price" class="block text-gray-700">Precio del producto</label>
                        <input type="numeric" name="cost_price" x-model="cost_price" required
                            class="w-full border px-3 py-2 rounded">
                    </div>
                    <div class="mb-4">
                        <label for="selling_price" class="block text-gray-700">Precio de venta</label>
                        <input type="numeric" name="selling_price" x-model="selling_price" required
                            class="w-full border px-3 py-2 rounded">
                    </div>
                    <button type="submit"
                        class="col-span-2 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Continuar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function createPriceModalData(modalId) {
        return {
            open: false,
            isEdit: false,
            createPriceTitle: '',
            product_name: '',
            product_id: '',
            cost_price: '',
            selling_price: '',
            id: '',
            products: @json($products),
            handleOpenModal(detail) {
                if (detail.modalId === modalId) {
                    this.open = true;
                    console.log(detail);
                    console.log(this.products);
                    if (detail.price) {
                        this.isEdit = true;
                        this.createPriceTitle = 'Editar precio del producto';
                        this.product_name = detail.price.product;
                        this.product_id = detail.price.name;
                        this.cost_price = detail.price.price;
                        this.selling_price = detail.price.sell_price;
                        this.id = detail.price.id;
                    }
                }
            }
        };
    }
</script>
