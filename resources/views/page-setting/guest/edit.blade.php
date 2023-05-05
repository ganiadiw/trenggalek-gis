<x-app-layout>
    <div class="py-8">
        <div class="static mx-auto max-w-7xl sm:px-6 lg:px-8">
            <form class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg" method="POST"
                action="{{ route('dashboard.page-settings.guest.update', ['guest_page_setting' => $guestPageSetting]) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h1 class="mb-5 text-lg font-bold text-gray-800">Ubah Data Pengaturan Halaman</h1>
                <div class="grid mb-5 gap-x-5">
                    <div class="mb-3">
                        <h2 class="block mb-3 text-base font-semibold text-gray-900">
                            {{ ucwords(str_replace('_', ' ', $guestPageSetting->key)) }}</h2>
                        @for ($i = 0; $i < $guestPageSetting->max_value; $i++)
                            <div class="flex space-x-2 space-y-5">
                                @if ($guestPageSetting->max_value > 1)
                                    <div class="flex w-5 mt-2 mr-4 md:-mt-2 md:items-center">{{ $i + 1 }}.</div>
                                @endif
                                @if ($guestPageSetting->input_type == 'file')
                                    <div class="w-full">
                                        @include('page-setting.guest.partials.file')
                                    </div>
                                @elseif ($guestPageSetting->input_type == 'text')
                                    <div class="w-full">
                                        @include('page-setting.guest.partials.text')
                                    </div>
                                @elseif ($guestPageSetting->input_type == 'textarea')
                                    <div class="w-full">
                                        @include('page-setting.guest.partials.textarea')
                                    </div>
                                @endif
                            </div>
                            @if ($errors->get('value_image.' . $i) || $errors->get('value_text.' . $i))
                                <p class="flex items-center mt-2 text-xs text-yellow-700">
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
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                </p>
                            @endif
                        @endfor
                    </div>
                </div>
                <div class="flex gap-x-2">
                    <a href="{{ route('dashboard.page-settings.guest.index') }}"
                        class="text-white bg-gray-600 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Kembali</a>
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
