<!-- Let all your things have their places; let each part of your business have its time. - Benjamin Franklin -->
@props([
    'name' => '',
    'modalTitle' => 'Titulo',
])
<div>
    <div
        x-data="{ show : false, modalName : '{{ $name }}' }"
        x-show="show"
        x-on:open-modal.window = "show = ($event.detail.modalId === modalName)"
        x-on:close-modal.window = "show = false"
        x-on:keydown.escape.window = "show = false"

    class="fixed inset-0 z-50 flex items-center justify-center" style="display: none;">
        <div class="absolute inset-0 bg-black opacity-50" x-on:click="show=false"></div>
        <div class="bg-white rounded-lg shadow-lg p-6 relative z-10 w-full max-w-md">
            <div class="flex flex-col justify-between items-center mb-4">
                <div class="flex justify-between w-full">
                    <h2 class="text-xl font-bold">
                        {{$title ?? $modalTitle}}
                    </h2>
                    <button x-on:click="$dispatch('close-modal')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                {{$slot}}
            </div>
        </div>
    </div>
</div>
