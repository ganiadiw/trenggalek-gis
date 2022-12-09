<x-app-layout>
    <div class="py-8">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-24">
            <h1 class="mb-5 font-bold text-gray-700">Tambah Data Administrator Sistem Informasi Geografis Wisata Trenggalek</h1>
            <form class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg" method="POST" action="{{ route('users.store') }}">
                @csrf
                <x-input-text-floating-label type="text" name="first_name" :value="old('first_name')" labelTitle="Nama Depan*" error='first_name'/>
                <x-input-text-floating-label type="text" name="last_name" :value="old('last_name')" labelTitle="Nama Belakang" error='last_name'/>
                <x-input-text-floating-label type="email" name="email" :value="old('email')" labelTitle="Email*" error='email'/>
                <x-input-text-floating-label type="text" name="username" :value="old('username')" labelTitle="Username*" error='username'/>
                <x-input-text-floating-label type="text" name="address" :value="old('address')" labelTitle="Alamat*" error='address'/>
                <x-input-text-floating-label type="text" name="phone_number" :value="old('phone_number')" labelTitle="Nomor Handphone*" error='phone_number'/>
                <x-input-text-floating-label class="mb-3" type="password" name="password" :value="old('password')" labelTitle="Password*" error='password'/>
                <p class="mb-4 text-sm text-red-500">* Wajib diisi</p>
                <p class="mb-5 text-sm text-yellow-600">
                    <span><svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg></span>
                    Data diri hanya dapat diakses oleh pemilik akun dan super admin
                </p>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
            </form>
        </div>
    </div>
</x-app-layout>
