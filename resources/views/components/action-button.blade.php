@props(['deleteURL' => null, 'editURL' => null, 'showURL' => null, 'downloadURL' => null, 'value' => null, 'relationshipCountOnDelete' => null, 'relationshipMessageOnDelete' => null])

<div x-data="{ initial: true, deleting: false }" class="flex items-center text-sm">
    <div class="flex items-center justify-center w-full">
        @if ($downloadURL)
            <div x-data="{ tooltipDownload: 'Download File Peta' }">
                <a x-show="initial" x-tooltip="tooltipDownload" href="{{ $downloadURL }}"
                    class="font-medium text-blue-600 hover:underline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-download"
                        width="22" height="22" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                        <path d="M12 17v-6"></path>
                        <path d="M9.5 14.5l2.5 2.5l2.5 -2.5"></path>
                    </svg>
                </a>
            </div>
            <span x-show="initial" class="mx-2">|</span>
        @endif
        @if ($showURL)
            <div x-data="{ tooltipShow: 'Detail' }">
                <a x-show="initial" x-tooltip="tooltipShow" href="{{ $showURL }}"
                    class="font-medium text-green-600 hover:underline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="22"
                        height="22" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                        <path
                            d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7">
                        </path>
                    </svg>
                </a>
            </div>
            <span x-show="initial" class="mx-2">|</span>
        @endif
        @if ($editURL)
            <div x-data="{ tooltipEdit: 'Edit' }">
                <a x-show="initial" x-tooltip="tooltipEdit" href="{{ $editURL }}"
                    class="font-medium text-blue-600 hover:underline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="22"
                        height="22" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                        <path d="M16 5l3 3"></path>
                    </svg>
                </a>
            </div>
            <span x-show="initial" class="mx-2">|</span>
        @endif
        @if ($deleteURL)
            <div x-data="{ tooltipDelete: 'Hapus' }">
                <button x-tooltip="tooltipDelete" x-on:click.prevent="deleting = true" x-show="initial"
                    x-on:deleting.window="$el.disabled = true"
                    class="font-medium text-red-600 rounded hover:underline disabled:opacity-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-1 icon icon-tabler icon-tabler-trash" width="22"
                        height="22" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 7l16 0"></path>
                        <path d="M10 11l0 6"></path>
                        <path d="M14 11l0 6"></path>
                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                    </svg>
                </button>
            </div>
        @endif
    </div>

    <div x-cloak x-show="deleting"
        x-on:click.outside="deleting = false; setTimeout(() => { initial = true })"
        x-on:click.outside="$el.disabled = true"
        class="fixed top-0 bottom-0 left-0 right-0 z-50 flex w-screen max-h-screen scale-100">

        <div class="relative flex items-center justify-center w-screen bg-gray-900 bg-opacity-80 md:h-auto">
            <div class="relative max-w-2xl bg-white rounded-lg shadow opacity-100">
                <button x-on:click.prevent="deleting = false; setTimeout(() => { initial = true })"
                    x-on:deleting.window="$el.disabled = true" type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div x-on:click.outside="deleting = false;" class="p-6 text-center">
                    <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    @if ($relationshipCountOnDelete > 0)
                        <h2 class="mb-5 text-lg font-normal text-gray-500">
                            {{ $relationshipMessageOnDelete }}
                        </h2>
                    @endif
                    <h3 class="mb-5 text-lg font-normal text-gray-500">Apakah anda yakin ingin menghapus data <span
                            class="font-semibold">{{ $value }}</span> ?</h3>
                    <div class="flex justify-center w-full mx-auto">
                        <form x-on:submit="$dispatch('deleting')" method="POST" action="{{ $deleteURL }}">
                            @csrf
                            @method('DELETE')
                            <button x-on:click="$el.form.submit()" x-on:deleting.window="$el.disabled = true"
                                type="submit"
                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                Hapus
                            </button>
                        </form>
                        <button x-on:click.prevent="deleting = false; setTimeout(() => { initial = true })"
                            x-on:deleting.window="$el.disabled = true" type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
