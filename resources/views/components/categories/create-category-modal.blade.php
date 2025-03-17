@props([
    'modalId' => 'createCategoryModal',
])
<div
    x-data="modalData('{{ $modalId }}')"
    x-on:open-modal.window="handleOpenModal($event.detail)"
    x-cloak>
    <x-reusable-modal :name="$modalId" x-show="open" x-cloak>
        <form
            :action="$store.categoriesModalData.isEdit ? `/categories/${id}` : '{{ route('categories.store') }}'"
            method="POST"
            class="mt-4 w-full">
            @csrf
            <template x-if="$store.categoriesModalData.isEdit">
                @method('PUT')
            </template>

            <x-slot name="title">
                <span x-text="$store.categoriesModalData.isEdit ? 'Actualizar Categoría' : 'Agregar Nueva Categoría'"></span>
            </x-slot>

            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nombre</label>
                <input type="text" name="name" id="name" required x-model="$store.categoriesModalData.name" class="w-full border px-3 py-2 rounded"
                >
            </div>
            <div class="mb-4">
                <label for="type" class="block text-gray-700">Tipo</label>
                <input type="text" name="type" id="type" required x-model="$store.categoriesModalData.type" class="w-full border px-3 py-2 rounded"
                >
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 w-full"
                x-text="$store.categoriesModalData.isEdit ? 'Actualizar Categoría' : 'Agregar Categoría'"></button>
        </form>
    </x-reusable-modal>
</div>
<script>
    function modalData(modalId) {
        return {
            open: false,
            handleOpenModal(detail) {
                if (detail.modalId === modalId) {
                    this.open = true;
                    if (detail.category) {
                        console.log(detail.category);
                        Alpine.store('categoriesModalData').setData({
                            isEdit: true,
                            category: detail.category,
                            name: detail.category.name,
                            type: detail.category.type,
                            id: detail.category.id,
                            editPath: `${window.location.origin}/categories/${detail.category.id}`,
                        });
                    } else {
                        Alpine.store('categoriesModalData').setData({
                            isEdit: false,
                            category: null,
                            name: '',
                            type: '',
                            id: '',
                            editPath: '',
                        });
                    }
                }
            }
        };
    }
</script>
