<section>
    <div class="flex space-x-8">
        <div class="flex items-center -mt-2 w-28">
            @if (isset($guestPageSetting->value[$i]) &&
                    Storage::exists('public/page-settings/' . $guestPageSetting->key . '/' . $guestPageSetting->value[$i]))
                <img class="object-cover rounded-md"
                    src="{{ asset('storage/page-settings/' . $guestPageSetting->key . '/' . $guestPageSetting->value[$i]) }}"
                    alt="{{ $guestPageSetting->value[$i] }}">
            @else
                <div class="flex justify-center w-full">
                    <a href="https://www.freeiconspng.com/img/23494"
                        title="Image from freeiconspng.com">
                        <img class="object-cover h-16"
                            src="https://www.freeiconspng.com/uploads/no-image-icon-15.png"
                            alt="No Save Icon Format" />
                    </a>
                </div>
            @endif
        </div>
        <div class="flex items-center w-[80%]">
            <input x-data="{ border: 'border-gray-300' }" type="file" name="value_image[]" id="value"
                class="block w-full px-4 mb-3 text-sm text-gray-900 border rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                autocomplete="off" accept=".png, .jpg, .jpeg" x-bind:class="border"
                x-on:change="border = 'border-green-300 border-2'">
        </div>
        @if (isset($guestPageSetting->value[$i]))
            <div x-data="handleDeleteImage()" class="flex items-center -mt-5">
                <button x-cloak x-show="deleteButton" type="button" x-data
                    x-tooltip.raw="Hapus"
                    x-on:click="deleteImage('{{ $guestPageSetting->key }}', '{{ $guestPageSetting->value[$i] }}')"
                    class="mt-1 font-medium text-red-600 rounded hover:underline disabled:opacity-50">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="mt-1 icon icon-tabler icon-tabler-trash" width="22"
                        height="22" viewBox="0 0 24 24" stroke-width="2.2"
                        stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 7l16 0"></path>
                        <path d="M10 11l0 6"></path>
                        <path d="M14 11l0 6"></path>
                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                    </svg>
                </button>
                <div x-cloak x-show="loading" role="status">
                    <svg aria-hidden="true"
                        class="w-6 h-6 mr-2 text-gray-200 animate-spin fill-green-600"
                        viewBox="0 0 100 101" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="currentColor" />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentFill" />
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        @endif
    </div>

    @section('script')
        <script>
            function handleDeleteImage() {
                return {
                    deleteButton: true,
                    loading: false,
                    deleteImage(key, filename) {
                        if (confirm('Apakah Anda yakin akan menghapusnya?')) {
                            this.deleteButton = false,
                                this.loading = true,
                                fetch('/dashboard/page-settings/guest/delete-image/' + key + '/' + filename, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    location.reload();
                                })
                        }
                    }
                }
            }
        </script>
    @endsection
</section>
