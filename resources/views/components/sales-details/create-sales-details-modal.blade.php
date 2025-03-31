@props([
    'modalId' => 'createSalesDetailModal',
    'users' => [],
    'products' => [],
])
<div x-data="createEditSalesDetailModalData('{{ $modalId }}')" x-on:open-modal.window="handleOpenModal($event.detail)" x-on:close-modal.window="open = false"
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
            <form :action="isEdit ? `/sales-details/${id}` : route('sales-details.store')" method="POST"
                class="mt-4 w-full">
                @csrf
                <template x-if="isEdit">
                    @method('PUT')
                </template>
                <div class="grid grid-cols-2 gap-2">
                    <div class="">
                        <label for="sales_id" class="block text-gray-700">Id de venta</label>
                        <input type="number" name="sales_id" x-model="sales_id" required
                            class="w-full border px-3 py-2 rounded">
                    </div>
                    <div class="">
                        <label for="quantity" class="block text-gray-700">Cantidad</label>
                        <input type="number" name="quantity" x-model="quantity" required
                            class="w-full border px-3 py-2 rounded">
                    </div>
                    <div class="col-span-2">
                        <label for="unit_price" class="block text-gray-700">Precio por unidad</label>
                        <input type="numeric" name="unit_price" x-model="unit_price" required
                            class="w-full border px-3 py-2 rounded">
                    </div>
                    <div class="mb-4 col-span-2">
                        <label for="product_id" class="block text-gray-700">Producto</label>
                        <select name="product_id" x-model="product_id" class="w-full">
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" x-text="isEdit ? 'Editar venta' : 'Crear nueva venta'"
                        class="col-span-2 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function createEditSalesDetailModalData(modalId) {
        return {
            open: false,
            isEdit: false,
            createEditSaleTitle: '',
            product_name: '',
            product_id: '',
            sales_id: '',
            quantity: '',
            unit_price: '',
            id: '',
            users: @json($users),
            products: @json($products),
            handleOpenModal(detail) {
                if (detail.modalId === modalId) {
                    this.open = true;
                    console.log(detail)
                    if (detail.salesDetail) {
                        this.isEdit = true;
                        this.createEditSaleTitle = 'Editar detalle de venta';
                        this.product_name = detail.salesDetail.product;
                        this.product_id = this.products.find((u) => u.name === this.product_name) ? this.products.find((
                            u) => u.name === this.product_name).id : this.products['1'];
                        this.sales_id = detail.salesDetail.sell_id;
                        this.quantity = detail.salesDetail.quantity;
                        this.unit_price = detail.salesDetail.unit_price;
                        this.id = detail.salesDetail.id;
                    } else {
                        this.isEdit = false;
                        this.createEditSaleTitle = 'Añadir nuevo detalle de venta';
                        this.product_name = '';
                        this.product_id = '';
                        this.sales_id = '';
                        this.quantity = '';
                        this.unit_price = '';
                        this.id = '';
                    }
                }
            }
        };
    }
</script>
