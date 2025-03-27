@props([
    'modalId' => 'createStockModal',
    'products' => [],
])
<div x-data="createStockModalData('{{ $modalId }}')" x-on:open-modal.window="handleOpenModal($event.detail)" x-on:close-modal.window="open = false"
    x-cloak>
    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black opacity-50"
            @click="$dispatch('close-modal', { name: '{{ $modalId }}' })"></div>
        <div class="bg-white rounded-lg shadow-lg p-6 relative z-10 w-full max-w-md"
            x-on:keydown.escape.window="$dispatch('close-modal', { name: '{{ $modalId }}' })">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold" x-text="createEditStockTitle"></h2>
                <button @click="$dispatch('close-modal', { name: '{{ $modalId }}' })">
                </button>
            </div>
            <form :action="isEdit ? `/stocks/${id}` : route('stocks.store')" method="POST" class="mt-4 w-full">
                @csrf
                <template x-if="isEdit">
                    @method('PUT')
                </template>
                <div class="grid grid-cols-2 gap-2">
                    <div class="mb-4 col-span-2">
                        <label for="product_id" class="block text-gray-700">Product</label>
                        <select name="product_id" id="product_id" x-model="product_id" class="w-full">
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4 col-span-2">
                        <label for="quantity" class="block text-gray-700">Cantidad</label>
                        <input type="number" name="quantity" x-model="quantity" required
                            class="w-full border px-3 py-2 rounded">
                    </div>
                    <button type="submit"
                        class="col-span-2 w-full bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700"
                        x-text="isEdit ? 'Actualizar producto' : 'Agregar producto'"></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function createStockModalData(modalId) {
        return {
            open: false,
            isEdit: false,
            createEditStockTitle: '',
            product_name: null,
            product_id: null,
            quantity: '',
            id: '',
            products: @json($products),
            handleOpenModal(detail) {
                if (detail.modalId === modalId) {
                    this.open = true;
                    if (detail.stock) {
                        this.isEdit = true;
                        this.createEditStockTitle = 'Editar producto en stock'
                        this.product_name = detail.stock.product;
                        this.product_id = this.products.find((p) => p.name === this.product_name) ? this.products.find((
                            p) => p.name === this.product_name).id : this.products[0]
                        this.quantity = detail.stock.quantity;
                        this.id = detail.stock.id;
                        console.log(detail)
                    } else {
                        this.isEdit = false;
                        this.createEditStockTitle = 'Añadir producto a stock'
                        this.product_name = null;
                        this.product_id = null;
                        this.product_id = '';
                        this.quantity = '';
                        this.id = '';
                    }
                }
            }
        };
    }
</script>
