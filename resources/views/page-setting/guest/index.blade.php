<x-app-layout>
    <div class="py-8">
        <div class="static mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="relative">
                <div class="grid w-full gap-3 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($settings as $key => $setting)
                        <div>
                            <div class="block p-6 mx-4 bg-white border border-gray-200 rounded-lg shadow md:mx-0 w-sm hover:bg-gray-100">
                                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">{{ ucwords(str_replace('_', ' ', $setting->key)) }}</h5>
                                <div class="h-[4rem] overflow-hidden">
                                    @foreach ($setting->value as $value)
                                        <div class="flex text-base">
                                            @if ($value)
                                                <div class="mr-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mt-[3px] text-green-500 icon icon-tabler icon-tabler-circle-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M7 3.34a10 10 0 1 1 -4.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 4.995 -8.336z" stroke-width="0" fill="currentColor"></path>
                                                    </svg>
                                                </div>
                                                <p class="text-sm font-normal text-gray-700 line-clamp-3">{{ $value }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <div class="flex justify-end mt-2">
                                    <a href="{{ route('dashboard.page-settings.guest.edit', ['guest_page_setting' => $setting]) }}" x-data x-tooltip.raw="Edit" class="text-blue-500 hover:text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                            <path d="M16 5l3 3"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
