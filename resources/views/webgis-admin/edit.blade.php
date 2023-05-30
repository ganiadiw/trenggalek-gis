<x-app-layout>
    <div>
        <div class="px-4 py-4 mx-auto text-gray-900 max-w-7xl sm:px-6 lg:px-8">
            <div class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg">
                <h1 class="w-full text-lg font-bold">Edit Data Administrator</h1>
                <div class="w-full mt-5">
                    <form method="POST" action="{{ route('dashboard.users.update', ['user' => $user]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid gap-5 lg:grid-cols-2">
                            <div>
                                <h2 class="text-base font-semibold text-gray-800">Data Diri</h2>
                                <div class="p-5 mt-3 border-2 border-gray-200 rounded-md shadow-md">
                                    <div x-data="{ open: false }">
                                        <div class="flex justify-center mb-5">
                                            <div class="relative">
                                                <div class="flex items-center justify-center p-1 rounded-full w-28 h-28 md:w-32 md:h-32">
                                                    <img id="avatar"
                                                        class="object-cover w-full h-full rounded-full"
                                                        src="{{ $user->avatar_name? asset('storage/avatars/' . $user->avatar_name): Avatar::create($user->name)->setDimension(500, 500)->setFontSize(230)->toBase64() }}"
                                                        alt="Bordered avatar">
                                                </div>
                                                <input x-on:change="open = true" type="file" id="avatarUpload"
                                                    name="avatar" hidden>
                                                <label for="avatarUpload" x-data x-tooltip.raw="Ubah foto"
                                                    x-tooltip.placement.bottom
                                                    class="absolute bottom-0 rounded-full ring-2 ring-offset-1 ring-white right-1">
                                                    <div
                                                        class="w-full p-1 bg-blue-500 rounded-full hover:brightness-[.80]">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-camera" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="#fff" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                            </path>
                                                            <path
                                                                d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2">
                                                            </path>
                                                            <circle cx="12" cy="13" r="3">
                                                            </circle>
                                                        </svg>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <p x-cloak x-show="open"
                                            class="flex justify-center mb-10 -mt-5 text-sm text-green-500">Klik simpan
                                            untuk menyimpan gambar
                                        </p>
                                    </div>
                                    <x-input-default-form type="text" name="name" :value="old('name', $user->name)" id="name"
                                        labelTitle="Nama Lengkap*" error='name' placeholder="{{ $user->name ?? 'Nama Lengkap' }}">
                                    </x-input-default-form>
                                    <x-input-default-form type="email" name="email" :value="old('email', $user->email)" id="email"
                                        labelTitle="Email*" error='email' placeholder="{{ $user->email ?? 'Email Valid' }}">
                                    </x-input-default-form>
                                    <x-input-default-form type="text" name="username" :value="old('username', $user->username)"
                                        id="username" labelTitle="Username*" error='username' placeholder="{{ $user->username ?? 'Username' }}">
                                    </x-input-default-form>
                                    <x-input-default-form type="text" name="address" :value="old('address', $user->address)" id="address"
                                        labelTitle="Alamat*" error='address'
                                        placeholder="{{ $user->address ?? 'Alamat Lengkap' }}">
                                    </x-input-default-form>
                                    <x-input-default-form type="text" name="phone_number" :value="old('phone_number', $user->phone_number)"
                                        id="phone_number" labelTitle="Nomor Handphone*" error='phone_number'
                                        placeholder="{{ $user->phone_number ?? 'Nomor Handphone' }}">
                                    </x-input-default-form>
                                </div>
                            </div>
                            <div>
                                <h2 class="font-semibold">Ubah Kata Sandi</h2>
                                <div class="p-5 mt-3 border-2 border-gray-200 rounded-md shadow-md">
                                    <div>
                                        <x-input-default-form type="password" name="password" id="password"
                                            labelTitle="Kata Sandi Baru" error='password' placeholder="*********">
                                        </x-input-default-form>
                                        <x-input-default-form type="password" name="password_confirmation"
                                            id="password_confirmation" labelTitle="Konfirmasi Kata Sandi"
                                            error='password_confirmation' placeholder="*********">
                                        </x-input-default-form>
                                    </div>
                                    <blockquote class="p-2 my-2 bg-gray-100 border-l-4 border-red-500 rounded-sm">
                                        <p class="text-[13px] font-medium italic leading-relaxed text-red-500">
                                            Hanya diisi jika ingin mengubah password
                                        </p>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                        <blockquote class="p-2 mt-4 bg-gray-100 border-l-4 border-yellow-300 rounded-sm">
                            <p class="text-[13px] font-medium italic leading-relaxed text-yellow-500">
                                Data diri hanya dapat diakses oleh pemilik akun dan super admin
                            </p>
                        </blockquote>
                        <div class="flex justify-end mt-8 gap-x-2">
                            <button type="button" onclick="history.back()"
                                class="text-white bg-gray-600 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Kembali</button>
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        @include('js.image-preview')
        <script>
            imagePreview(document.getElementById('avatar'), document.getElementById('avatarUpload'), 'change');
        </script>
    @endsection
</x-app-layout>
