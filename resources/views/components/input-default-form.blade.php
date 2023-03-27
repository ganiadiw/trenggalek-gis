@props(['type', 'name' => null, 'value' => null, 'labelTitle' => null, 'error' => null, 'id' => null, 'placeholder' => ' ', 'readonly' => false, 'disabled' => false, 'desc' => null])

<div {{ $attributes->merge(['class' => 'mb-3']) }}>
    <label for="{{ $id }}" class="block mb-2 text-sm font-medium text-gray-900">{{ $labelTitle }}</label>
    <input type="{{ $type }}" name="{{ $name }}" value="{{ $value }}" id="{{ $id }}"
        @readonly($readonly == true) @disabled($disabled == true)
        {{ $attributes->merge(['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 px-4']) }}
        placeholder="{{ $placeholder }}" autocomplete="off">
    @if ($desc)
        <p class="mt-1 text-sm text-gray-500 ">{{ $desc }}</p>
    @endif
    @error($error)
        <p class="flex items-center mt-2 text-xs text-yellow-700">
            <span class="mr-3 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle" width="20"
                    height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <circle cx="12" cy="12" r="9"></circle>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                    <polyline points="11 12 12 12 12 16 13 16"></polyline>
                </svg>
            </span>
            {{ $message }}
        </p>
    @enderror
</div>
