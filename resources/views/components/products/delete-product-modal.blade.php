@props([
    'modalId' => 'deleteProductModal',
])
<div x-data="deleteProductModalData('{{ $modalId }}')" x-on:open-modal.window="handleOpenModal($event.detail)" x-on:close-modal.window="open = false"
    x-cloak>
    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black opacity-50"
            @click="$dispatch('close-modal', { name: '{{ $modalId }}' })"></div>
        <div class="bg-white rounded-lg shadow-lg p-6 relative z-10 w-full max-w-md"
            x-on:keydown.escape.window="$dispatch('close-modal', { name: '{{ $modalId }}' })">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold" x-text="createEditProductTitle"></h2>
                <button @click="$dispatch('close-modal', { name: '{{ $modalId }}' })">
                    <!-- Close Icon -->
                </button>
            </div>
            <form :action="`/products/${id}`" method="POST" class="mt-4 w-full">
                @csrf
                @method('DELETE')
                <p class="mb-4">
                    ¿Seguro que deseas eliminar el producto: <strong x-text="name"></strong>, y todas sus relaciones?
                </p>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 w-full"
                    x-text="'Confirmar'"></button>
            </form>
        </div>
    </div>
</div>

<script>
    function deleteProductModalData(modalId) {
        return {
            open: false,
            id: '',
            name: '',
            createEditProductTitle: 'Eliminar Producto',
            handleOpenModal(detail) {
                if (detail.modalId === modalId) {
                    this.open = true;
                    this.createEditProductTitle = 'Eliminar Producto';
                    this.id = detail.product.id;
                    this.name = detail.product.name;
                }
            }
        };
    }
</script>
