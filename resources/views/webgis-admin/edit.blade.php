<x-app-layout>
    <div class="py-8">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-24">
            <form class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg" method="POST"
                action="{{ route('users.update', ['user' => $user]) }} " enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h1 class="text-lg font-bold text-gray-700">
                    Ubah Data Administrator Sistem Informasi Geografis Wisata Trenggalek</h1>
                <div x-data="{ open: false }">
                    <div class="flex justify-center mt-10 mb-10">
                        <div class="relative">
                            <img id="avatar"
                                class="flex items-center justify-center p-1 rounded-full w-44 h-44 lg:w-64 lg:h-64"
                                src="{{ $user->avatar_name? asset('storage/avatars/' . $user->avatar_name): Avatar::create($user->name)->setDimension(500, 500)->setFontSize(230)->toBase64() }}"
                                alt="Bordered avatar">
                            <input x-on:change="open = true" type="file" id="avatarUpload" name="avatar" hidden>
                            <label for="avatarUpload" data-tooltip-target="tooltip-animation"
                                data-tooltip-placement="right"
                                class="absolute bottom-0 rounded-full ring-2 ring-offset-1 ring-white right-5 lg:right-10">
                                <div class="w-full p-2 bg-blue-500 rounded-full hover:brightness-[.80]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-camera"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="#fff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2">
                                        </path>
                                        <circle cx="12" cy="13" r="3"></circle>
                                    </svg>
                                </div>
                            </label>
                            <div id="tooltip-animation" role="tooltip"
                                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-blue-500 rounded-lg shadow-sm opacity-0 w-fit tooltip">
                                Ubah foto
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                    </div>
                    <p x-show="open" class="flex justify-center mb-10 -mt-5 text-sm text-green-500">Klik simpan untuk
                        menyimpan gambar</p>
                </div>
                <div class="grid gap-x-5 md:grid-cols-2">
                    <x-input-default-form type="text" name="name" :value="old('name', $user->name)" id="name"
                        labelTitle="Nama Lengkap*" error='name' placeholder="John"></x-input-default-form>
                    <x-input-default-form type="email" name="email" :value="old('email', $user->email)" id="email"
                        labelTitle="Email*" error='email' placeholder="johndoe@mail.com"></x-input-default-form>
                    <x-input-default-form type="text" name="username" :value="old('username', $user->username)" id="username"
                        labelTitle="Username*" error='username' placeholder="johndoe123"></x-input-default-form>
                    <x-input-default-form type="text" name="address" :value="old('address', $user->address)" id="address"
                        labelTitle="Alamat*" error='address'
                        placeholder="RT/RW 002/001, Desa Panggul, Kecamatan Panggul"></x-input-default-form>
                    <x-input-default-form type="text" name="phone_number" :value="old('phone_number', $user->phone_number)" id="phone_number"
                        labelTitle="Nomor Handphone*" error='phone_number' placeholder="081234567889">
                    </x-input-default-form>
                </div>
                <div class="p-6 mb-4 bg-gray-200 rounded-lg shadow-lg">
                    <p class="mb-4 text-sm font-semibold text-red-500">Hanya diisi jika ingin mengubah password</p>
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-6 group">
                            <x-input-default-form class="-mb-1 lg:-mb-5" type="password" name="new_password"
                                id="new_password" labelTitle="Password Baru" error='new_password'
                                placeholder="*********"></x-input-default-form>
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <x-input-default-form class="-mb-1 lg:-mb-5" type="password" name="password_confirmation"
                                id="password_confirmation" labelTitle="Konfirmasi Password"
                                error='password_confirmation' placeholder="*********"></x-input-default-form>
                        </div>
                        @if (session('error'))
                            <p id="standard_error_help"
                                class="flex items-center text-xs text-yellow-700 md:-mt-5 lg:-mt-1">
                                <span class="mr-3 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-info-circle" width="20"
                                        height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <circle cx="12" cy="12" r="9"></circle>
                                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                        <polyline points="11 12 12 12 12 16 13 16"></polyline>
                                    </svg>
                                </span>
                                {{ session('error') }}
                            </p>
                        @endif
                    </div>
                </div>
                <p class="mb-5 text-sm text-yellow-600">
                    <span><svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg></span>
                    Data diri hanya dapat diakses oleh pemilik akun dan super admin
                </p>
                <div class="flex gap-x-2">
                    <a href="{{ route('users.index') }}"
                        class="text-white bg-gray-600 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Kembali</a>
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    @section('script')
        @include('js.image-preview')
        <script>
            imagePreview(document.getElementById('avatar'), document.getElementById('avatarUpload'), 'change')
        </script>
    @endsection
</x-app-layout>
