<x-app-layout>
    <div class="py-8">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-24">
            <h1 class="mb-5 font-bold text-gray-700">Ubah Data Administrator Sistem Informasi Geografis Wisata Trenggalek</h1>
            <form class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg" method="POST" action="{{ route('users.update', ['user' => $user]) }} " enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-input-text-floating-label type="text" name="first_name" :value="old('first_name', $user->first_name)" labelTitle="Nama Depan*" error='first_name'/>
                <x-input-text-floating-label type="text" name="last_name" :value="old('last_name', $user->last_name)" labelTitle="Nama Belakang" error='last_name'/>
                <x-input-text-floating-label type="email" name="email" :value="old('email', $user->email)" labelTitle="Email*" error='email'/>
                <x-input-text-floating-label type="text" name="username" :value="old('username',$user->username)" labelTitle="Username*" error='username'/>
                <x-input-text-floating-label type="text" name="address" :value="old('address', $user->address)" labelTitle="Alamat*" error='address'/>
                <x-input-text-floating-label class="mb-3" type="text" name="phone_number" :value="old('phone_number', $user->phone_number)" labelTitle="Nomor Handphone*" error='phone_number'/>
                <div class="mb-3">
                    <label class="block mb-2 text-sm text-gray-700 " for="file_input">Upload Foto Profil <span class="font-semibold text-black">(Isi hanya jika ingin mengubahnya)</span></label>
                    <input class="block w-full h-10 px-3 py-2 text-sm text-gray-900 border border-gray-300 rounded-sm cursor-pointer bg-gray-50 focus:outline-none" name="avatar" aria-describedby="file_input_help" id="file_input" type="file">
                    <p class="mt-1 text-sm text-gray-500" id="file_input_help">PNG, JPG (MAX. 2048KB / 2MB).</p>
                    @error('avatar')
                        <p id="standard_error_help" class="flex items-center mt-2 text-xs text-yellow-700">
                            <span class="mr-3 font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                <div class="p-6 mb-4 bg-gray-200 rounded-lg shadow-lg">
                    <p class="mb-4 text-sm font-semibold text-red-500">Hanya diisi jika ingin mengubah password</p>
                    <div class="grid md:grid-cols-2 md:gap-6">
                        <div class="relative z-0 w-full mb-6 group">
                            <x-input-text-floating-label class="-mb-1 lg:-mb-5" type="password" name="new_password" labelTitle="Password Baru" error='new_password'/>
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                          <x-input-text-floating-label class="-mb-1 lg:-mb-5" type="password" name="password_confirmation" labelTitle="Konfirmasi Password" error='password_confirmation'/>
                        </div>
                        @if (session('error'))
                            <p id="standard_error_help" class="flex items-center text-xs text-yellow-700 md:-mt-5 lg:-mt-1">
                                <span class="mr-3 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                    <span><svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg></span>
                    Data diri hanya dapat diakses oleh pemilik akun dan super admin
                </p>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
            </form>
        </div>
    </div>
</x-app-layout>
