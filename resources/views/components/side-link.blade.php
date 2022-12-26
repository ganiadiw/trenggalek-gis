@props(['active', 'svgIcon' => null , 'spanClasses' => 'w-1 bg-blue-500 rounded-tr-lg rounded-br-lg', 'titleClasses' => 'ml-4'])

@php
    $spanClasses = ($active ?? false)
                ? $spanClasses
                : 'hidden';

    $classes = ($active ?? false)
                ? 'flex items-center w-full h-12 pl-4 my-1 text-black font-bold'
                : 'flex items-center w-full h-12 pl-4 hover:bg-gray-300 my-1 mx-1 hover:rounded-md hover:text-gray-900';

@endphp

<span {{ $attributes->merge(['class' => $spanClasses]) }}></span>
<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $svgIcon }}
    <span {{ $attributes->merge(['class' => $titleClasses]) }}>{{ $title }}</span>
</a>
