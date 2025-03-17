@props([
    'modalId' => 'deleteCategoryModal',
])
<div
    x-data="modalData('{{ $modalId }}')"
    x-on:open-modal.window="handleOpenModal($event.detail)"
    x-cloak
>
    <x-reusable-modal :name="$modalId" x-show="open" x-cloak>
        <form
            :action="`/categories/$id`"
            method="POST" class="mt-4 w-full"
            @csrf
            <x-slot name="title">
                <span x-text="'Eliminar Categoría'"></span>
            </x-slot>

            <p class="mb-4">
                ¿Seguro que deseas eliminar la categoría: <strong x-text="name"></strong>?
            </p>

            <button type="submit"
                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 w-full">
                Eliminar
            </button>
        </form>
    </x-reusable-modal>
</div>
<script>
    function modalData(modalId) {
        return {
            open: false,
            category: null,
            name: '',
            type: '',
            id: '',
            handleOpenModal(detail) {
                if (detail.modalId === modalId) {
                    this.open = true;
                    if (detail.category) {
                        this.category = detail.category;
                        this.name = detail.category.name;
                        this.type = detail.category.type;
                        this.id = detail.category.id;
                    } else {
                        this.category = null;
                        this.name = '';
                        this.type = '';
                        this.id = '';
                    }
                }
            }
        };
    }
</script>
