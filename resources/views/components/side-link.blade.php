@props(['active'])

@php
    $spanClasses = ($active ?? false)
                ? 'w-1 bg-blue-500 rounded-tr-lg rounded-br-lg'
                : 'hidden';

    $classes = ($active ?? false)
                ? 'flex items-center w-full h-12 pl-6 hover:bg-gray-300'
                : 'flex items-center w-full h-12 pl-6 hover:bg-gray-300 ml-1 text-gray-700'
@endphp

<span {{ $attributes->merge(['class' => $spanClasses]) }}></span>
<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $svgIcon }}
    <span class="ml-4">{{ $title }}</span>
</a>
