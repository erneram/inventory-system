@props([
    'modalId' => 'createProductModal',
    'categories' => [],
    'stocks' => [],
    'prices' => [],
])
<div x-data="createEditProductModalData('{{ $modalId }}')" x-on:open-modal.window="handleOpenModal($event.detail)" x-on:close-modal.window="open = false"
    x-cloak>
    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black opacity-50"
            @click="$dispatch('close-modal', { name: '{{ $modalId }}' })"></div>
        <div class="bg-white rounded-lg shadow-lg p-6 relative z-10 w-full max-w-md"
            x-on:keydown.escape.window="$dispatch('close-modal', { name: '{{ $modalId }}' })">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold" x-text="createEditProductTitle"></h2>
                <button @click="$dispatch('close-modal', { name: '{{ $modalId }}' })">
                </button>
            </div>
            <form :action="isEdit ? `/products/${id}` : route('products.store')" method="POST" class="mt-4 w-full">
                @csrf
                <template x-if="isEdit">
                    @method('PUT')
                </template>
                <div class="grid grid-cols-2 gap-2">
                    <div class="col-span-2">
                        <label for="name" class="block text-gray-700">Nombre</label>
                        <input type="text" name="name" x-model="name" required
                            class="w-full border px-3 py-2 rounded">
                    </div>
                    <div class="col-span-2 ">
                        <label for="description" class="block text-gray-700">Descripción</label>
                        <textarea name="description" x-model="description" required class="w-full border px-3 py-2 rounded"></textarea>
                    </div>
                    <div class="">
                        <label for="cost_price" class="block text-gray-700">Precio</label>
                        <input type="numeric" name="cost_price" x-model="cost_price" required
                            class="w-full border px-3 py-2 rounded">
                    </div>
                    <div class="">
                        <label for="stock_quantity" class="block text-gray-700">Cantidad en almacen</label>
                        <input type="number" name="stock_quantity" x-model="stock_quantity" required
                            class="w-full border px-3 py-2 rounded">
                    </div>
                    <div class="col-span-2">
                        <label for="category_id" class="block text-gray-700">Categorias</label>
                        <select name="categories_id" id="category_id" x-model="category_id" class="w-full">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit"
                        class="col-span-2 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 w-full"
                        x-text="isEdit ? 'Actualizar produto' : 'Agregar producto'"></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function createEditProductModalData(modalId) {
        return {
            open: false,
            isEdit: false,
            createEditProductTitle: '',
            product: null,
            name: '',
            description: '',
            cost_price: '',
            stock_quantity: '',
            category_id: '',
            id: '',
            prices: @json($prices),
            stocks: @json($stocks),
            handleOpenModal(detail) {
                if (detail.modalId === modalId) {
                    this.open = true;
                    if (detail.product) {
                        this.isEdit = true;
                        this.createEditProductTitle = 'Editar producto';
                        this.product = detail.product;
                        this.name = detail.product.name;
                        this.description = detail.product.description;
                        this.id = detail.product.id;
                        this.cost_price = this.prices.find((p) => p.product_id === this.id) ? this.prices.find((p) => p
                            .product_id === this.id).cost_price : '0';
                        this.stock_quantity = this.stocks.find((s) => s.product_id === this.id) ? this.stocks.find((
                            s) => s.product_id === this.id).quantity : '0';
                        this.category_id = '';
                        console.log(this.stocks);
                    } else {
                        this.isEdit = false;
                        this.createEditProductTitle = 'Añadir nuevo producto';
                        this.product = null;
                        this.name = '';
                        this.description = '';
                        this.id = '';
                        this.cost_price = '';
                        this.stock_quantity = '';
                        this.category_id = '';
                    }
                }
            }
        };
    }
</script>
