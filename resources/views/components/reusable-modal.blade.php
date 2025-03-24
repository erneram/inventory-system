@props([
    'name' => '',
    'modalTitle' => 'Título',
])
<div {{ $attributes->merge([
    'class' => 'fixed inset-0 z-50 flex items-center justify-center',
    'x-on:keydown.escape.window' => "\$dispatch('close-modal', { name: '$name' })"
]) }}>
    <div class="absolute inset-0 bg-black opacity-50" @click="$dispatch('close-modal', { name: '{{ $name }}' })"></div>
    <div class="bg-white rounded-lg shadow-lg p-6 relative z-10 w-full max-w-md">
        <div class="flex flex-col justify-between items-center mb-4">
            <div class="flex justify-between w-full">
                {{ $title ?? $modalTitle }}
                <button @click="$dispatch('close-modal', { name: '{{ $name }}' })">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            {{ $slot }}
        </div>
    </div>
</div>
