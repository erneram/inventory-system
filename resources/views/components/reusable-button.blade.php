@props([
    'styleButton' => 'bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600',
    'icon' => null,
    'btnText' => 'Boton'
])
<button {{  $attributes->merge(['class' => $styleButton]) }}>
    @if ($icon)
        isIcon
    @endif
    {{$btnText}}
</button>
