@props(['deleteURL', 'editURL', 'showURL', 'value'])

<div x-data="{ initial: true, deleting: false }" class="flex items-center text-sm">
    <div class="flex items-center justify-center w-full">
        <div x-data="{ tooltipShow : 'Detail' }">
            <a x-show="initial" x-tooltip="tooltipShow" href="{{ $showURL }}" class="font-medium text-green-600 hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="22" height="22" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                    <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"></path>
                </svg>
            </a>
        </div>
        <span x-show="initial" class="mx-2">|</span>
        <div x-data="{ tooltipEdit : 'Edit' }">
            <a x-show="initial" x-tooltip="tooltipEdit" href="{{ $editURL }}" class="font-medium text-blue-600 hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="22" height="22" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                    <path d="M16 5l3 3"></path>
                </svg>
            </a>
        </div>
        <span x-show="initial" class="mx-2">|</span>
        <div x-data="{ tooltipDelete : 'Hapus' }">
            <button x-tooltip="tooltipDelete" x-on:click.prevent="deleting = true; initial = false" x-show="initial"
                x-on:deleting.window="$el.disabled = true"
                class="font-medium text-red-600 rounded hover:underline disabled:opacity-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="mt-1 icon icon-tabler icon-tabler-trash" width="22" height="22" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M4 7l16 0"></path>
                    <path d="M10 11l0 6"></path>
                    <path d="M14 11l0 6"></path>
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                </svg>
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

        <form x-on:submit="$dispatch('deleting')" class="space-x-1" method="post" action="{{ $deleteURL }}">
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
