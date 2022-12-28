@props(['action', 'href', 'buttonEditText' => __('Edit'), 'buttonDeleteText' => __('Hapus'), 'value'])

<div x-data="{ initial: true, deleting: false }" class="flex items-center text-sm">
    <div class="flex items-center justify-center w-full">
        <div>
            <a x-show="initial" href="{{ $href }}" class="font-medium text-blue-600 hover:underline">
                {{ $buttonEditText }}
            </a>
        </div>
        <span x-show="initial" class="mx-2">|</span>
        <div>
            <button x-on:click.prevent="deleting = true; initial = false" x-show="initial"
                x-on:deleting.window="$el.disabled = true"
                class="font-medium text-red-600 rounded hover:underline disabled:opacity-50">
                {{ $buttonDeleteText }}
            </button>
        </div>
    </div>

    <div x-cloak x-show="deleting" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90"
        x-on:click.outside="deleting = false; setTimeout(() => { initial = true })"
        x-on:click.outside="$el.disabled = true" class="absolute flex space-x-3 scale-100 right-3 xl:right-8">
        <span class="px-5 py-1 text-sm text-gray-200 bg-gray-600 rounded-md">@lang('Hapus ') <span
                class="font-semibold underline">{{ $value }}</span> @lang('?')</span>

        <form x-on:submit="$dispatch('deleting')" class="space-x-1" method="post" action="{{ $action }}">
            @csrf
            @method('DELETE')

            <button x-on:click="$el.form.submit()" x-on:deleting.window="$el.disabled = true" type="submit"
                class="px-2 py-1 text-white bg-red-600 rounded hover:bg-red-700 disabled:opacity-50">
                @lang('Hapus')
            </button>

            <button x-on:click.prevent="deleting = false; setTimeout(() => { initial = true })"
                x-on:deleting.window="$el.disabled = true"
                class="px-2 py-1 text-white bg-gray-600 rounded hover:bg-gray-700 disabled:opacity-50">
                @lang('Tidak')
            </button>
        </form>
    </div>
</div>
