@props([
    'modalId' => 'createSaleModal',
    'users' => [],
    'products' => [],
    'prices' => [],
    'salesDetails' => [],
    'currentUserId' => '',
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
                <input type="hidden" name="products_array" :value="JSON.stringify(productsArray)">
                <div class="grid grid-cols-2 gap-2">
                    <div class="mb-2 col-span-2">
                        <label for="user_id" class="block text-gray-700">Usuarios</label>
                        <select name="user_id" x-model="user_id" class="w-full">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <template x-if="productsArray.length > 0">
                        <div class="col-span-2 space-y-2">
                            <template x-for="(item, index) in productsArray" :key="index">
                                <div class="flex items-center justify-around border p-2 rounded">
                                    <span x-text="`Producto ID: ${item.product_id}`"></span>
                                    <span x-text="`Cantidad: ${item.quantity}`"></span>
                                    <span x-text="`Precio en venta: ${item.total_price}`"></span>
                                    <button type="button"
                                        @click="removeObjectById(productsArray, item.product_id, item.quantity)">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 9.75 14.25 12m0 0 2.25 2.25M14.25 12l2.25-2.25M14.25 12 12 14.25m-2.58 4.92-6.374-6.375a1.125 1.125 0 0 1 0-1.59L9.42 4.83c.21-.211.497-.33.795-.33H19.5a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25h-9.284c-.298 0-.585-.119-.795-.33Z" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </template>
                    <div class="flex items-center col-span-2">
                        <h2 class="text-md font-bold mr-4" x-text="'Agregar productos'"></h2>
                        <button type="button" @click="addNewProduct">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </button>
                    </div>
                    <template x-if="addProductBool">
                        <div class="flex-col ml-4 col-span-2">
                            <div>
                                <label for="product_id" class="block text-gray-700">Producto</label>
                                <select name="product_id" x-model="selectedProductId" class="w-full">
                                    <option value="" disabled selected hidden>Seleccione el producto</option>
                                    @foreach ($products as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="selectedQuantity" class="block text-gray-700">Cantidad</label>
                                <input type="numeric" name="selectedQuantity" x-model="selectedQuantity" required
                                    class="w-full border px-3 py-2 rounded">
                            </div>
                            <div>
                                <button type="button" @click="addProducts(selectedProductId, selectedQuantity)">Agregar
                                    producto</button>
                            </div>
                        </div>
                    </template>
                    <div class="mb-4 col-span-2">
                        <label for="total_price" class="block text-gray-700">Precio total</label>
                        <input type="numeric" name="total_price" x-model="total_price" required
                            class="w-full border px-3 py-2 rounded">
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
            addProductBool: false,
            createEditSaleTitle: '',
            user_name: '',
            user_id: '{{ $currentUserId }}',
            total_price: 0.0,
            id: '',
            productsArray: [],
            selectedProductId: '',
            selectedQuantity: '',
            users: @json($users),
            products: @json($products),
            prices: @json($prices),
            salesDetail: @json($salesDetails),
            handleOpenModal(detail) {
                if (detail.modalId === modalId) {
                    this.open = true;
                    console.log(this.salesDetail);
                    if (detail.sales) {
                        this.isEdit = true;
                        this.createEditSaleTitle = 'Editar venta';
                        this.user_name = detail.sales.user;
                        this.user_id = this.users.find((u) => u.name === this.user_name) ? this.users.find((u) => u
                            .name === this.user_name).id : '0';
                        this.total_price = parseFloat(detail.sales.price);
                        this.id = detail.sales.id;
                        this.salesDetail.forEach(sale => {
                            if (sale.sales_id === this.id) {
                                this.addProducts(sale.product.id, sale.quantity, true);
                            }
                        });
                    } else {
                        this.isEdit = false;
                        this.addProductBool = false
                        this.createEditSaleTitle = 'Añadir nueva venta';
                        this.user_name = null;
                        this.user_id = '{{ $currentUserId }}';
                        this.id = '';
                        this.productsArray = [];
                    }
                }
            },
            addNewProduct() {
                this.addProductBool = true;
            },
            addProducts(product_id, quantity, forFilling = false) {
                if (!product_id || !quantity) {
                    alert("Debes seleccionar un producto y una cantidad.");
                    return;
                }
                const priceEntry = this.prices.find((p) => p.product_id == product_id);
                if (!priceEntry) {
                    alert("No se encontró el precio para el producto seleccionado.");
                    return;
                }
                const temporalData = {
                    product_id: product_id,
                    quantity: quantity,
                    total_price: priceEntry.selling_price,
                };
                this.productsArray.push(temporalData);
                if (forFilling === false) {
                    this.total_price = parseFloat(this.total_price) + (parseFloat(priceEntry.selling_price) *
                        parseFloat(
                            quantity));
                }
                this.selectedProductId = '';
                this.selectedQuantity = '';
                this.addProductBool = false;
            },
            removeObjectById(arr, id, quantity) {
                const productPrice = this.prices.find((p) => p.product_id == id);
                this.total_price = parseFloat(this.total_price) - parseFloat(parseFloat(quantity) * parseFloat(
                    productPrice.selling_price));
                const objWithIdIndex = arr.findIndex((obj) => obj.id === id);
                arr.splice(objWithIdIndex, 1);
                return arr;
            }
        };
    }
</script>
