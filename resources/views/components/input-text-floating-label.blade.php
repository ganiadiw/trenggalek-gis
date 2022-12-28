@props(['type', 'name', 'value' => null, 'labelTitle', 'error', 'id' => null])

<div {{ $attributes->merge(['class' => 'mb-5']) }}>
    <div class="relative z-0">
        <input type="{{ $type }}" name="{{ $name }}" value="{{ $value }}" id="{{ $id }}"
            aria-describedby="standard_error_help"
            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 peer"
            placeholder=" " autocomplete="off" />
        <label for="standard_error"
            class="peer-focus:font-medium absolute text-sm text-gray-700 duration-300 transform -translate-y-6 scale-90 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-90 peer-focus:-translate-y-6">{{ $labelTitle }}</label>
    </div>
    @error($error)
        <p id="standard_error_help" class="flex items-center mt-2 text-xs text-yellow-700">
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
