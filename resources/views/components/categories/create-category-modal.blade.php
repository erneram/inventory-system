@props([
    'modalId' => 'createCategoryModal',
])
<div 
    x-data="modalData('{{ $modalId }}')" 
    x-on:open-modal.window="handleOpenModal($event.detail)"
    x-on:close-modal="open = false"
    x-cloak>
    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black opacity-50" 
             @click="$dispatch('close-modal', { name: '{{ $modalId }}' })"></div>
        <div class="bg-white rounded-lg shadow-lg p-6 relative z-10 w-full max-w-md"
             x-on:keydown.escape.window="$dispatch('close-modal', { name: '{{ $modalId }}' })">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold" x-text="createEditTitle"></h2>
                <button @click="$dispatch('close-modal', { name: '{{ $modalId }}' })">
                    <!-- Close Icon -->
                </button>
            </div>
            <form :action="isEdit ? '/categories/' + id : '{{ route('categories.store') }}'" method="POST" class="mt-4 w-full">
                @csrf
                <template x-if="isEdit">
                    @method('PUT')
                </template>
                <div class="mb-4">
                    <label class="block text-gray-700">Nombre</label>
                    <input type="text" name="name" required x-model="name" class="w-full border px-3 py-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Tipo</label>
                    <input type="text" name="type" required x-model="type" class="w-full border px-3 py-2 rounded">
                </div>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 w-full"
                        x-text="isEdit ? 'Actualizar Categoría' : 'Agregar Categoría'"></button>
            </form>
        </div>
    </div>
</div>

<script>
    function modalData(modalId) {
        return {
            open: false,
            isEdit: false,
            id: '',
            name: '',
            type: '',
            createEditTitle: '',
            handleOpenModal(detail) {
                if (detail.modalId === modalId) {
                    this.open = true;
                    if (detail.category) {
                        this.createEditTitle = 'Actualizar Categoría';
                        this.isEdit = true;
                        this.id = detail.category.id;
                        this.name = detail.category.name;
                        this.type = detail.category.type;
                    } else {
                        this.createEditTitle = 'Agregar Categoría';
                        this.isEdit = false;
                        this.id = '';
                        this.name = '';
                        this.type = '';
                    }
                }
            }
        };
    }
</script>
