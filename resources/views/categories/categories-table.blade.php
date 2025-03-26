<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6 text-white">Categorías</h1>

        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <x-reusable-table :columns="[
            ['field' => 'id', 'name' => 'ID', 'hasAction' => false],
            ['field' => 'name', 'name' => 'Nombre', 'hasAction' => false],
            ['field' => 'type', 'name' => 'Tipo', 'hasAction' => false],
            ['field' => 'created_at', 'name' => 'Creado', 'hasAction' => false],
        ]" :rows="$categories
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'type' => $category->type,
                    'created_at' => $category->created_at ? $category->created_at->format('d/m/Y H:i') : '',
                ];
            })
            ->toArray()">
            <x-slot name="rowActions">
                <div class="flex flex-row justify-between">
                    <span x-data @click="$dispatch('open-modal', { modalId: 'createCategoryModal', category: row })"
                        class="cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6 text-blue-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                        </svg>
                    </span>
                    <span x-data @click="$dispatch('open-modal', { modalId: 'deleteCategoryModal', category: row })"
                        class="cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6 text-red-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </span>
                </div>
            </x-slot>
        </x-reusable-table>

        <div class="flex justify-center mt-4">
            <x-reusable-button x-data @click="$dispatch('open-modal', { modalId: 'createCategoryModal'})"
                btnText="Agregar Categoría" />
        </div>

        <x-categories.create-category-modal modalId="createCategoryModal" />
        <x-categories.delete-category-modal modalId="deleteCategoryModal" />
    </div>
</x-app-layout>
