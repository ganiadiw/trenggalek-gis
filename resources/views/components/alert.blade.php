@if (session('success'))
    <div
        x-data="{show: true}"
        x-show="show"
        x-init="setTimeout(() => show = false, 3000)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="flex justify-end">
        <div id="toast-simple" class="absolute flex items-center p-2 mt-10 mr-5 space-x-4 text-white bg-green-500 divide-x divide-gray-200 rounded-md shadow w-72 top-1" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <circle cx="12" cy="12" r="9"></circle>
                <path d="M9 12l2 2l4 -4"></path>
            </svg>
            <div class="pl-4 text-sm font-semibold">{{ session('success') }}</div>
        </div>
    </div>
@endif
