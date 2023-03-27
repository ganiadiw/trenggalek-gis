@props(['labelTitle', 'disabledSelected', 'id', 'error', 'name'])

<div {{ $attributes->merge(['class' => 'mb-3']) }}>
    <label for="{{ $id }}" class="block mb-2 text-sm font-medium text-gray-900">{{ $labelTitle }}</label>
    <select id="{{ $id }}" name="{{ $name }}" required
        class="w-full text-sm py-2.5 px-4 text-gray-900 border-gray-300 rounded-md bg-gray-50">
        {{ $options }}
    </select>
    @error($error)
        <p id="standard_error_help" class="flex items-center mt-2 text-xs text-yellow-700">
            <span class="mr-3 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="icon icon-tabler icon-tabler-info-circle" width="20"
                    height="20" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <circle cx="12" cy="12" r="9"></circle>
                    <line x1="12" y1="8" x2="12.01" y2="8">
                    </line>
                    <polyline points="11 12 12 12 12 16 13 16"></polyline>
                </svg>
            </span>
            {{ $message }}
        </p>
    @enderror
</div>
