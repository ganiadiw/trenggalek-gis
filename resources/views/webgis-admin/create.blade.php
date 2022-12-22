<x-app-layout>
    <div class="py-4">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <form class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg" method="POST" action="{{ route('users.store') }}">
                @csrf
                <h1 class="mb-5 text-lg font-bold text-gray-700">Tambah Data Administrator Sistem Informasi Geografis Wisata Trenggalek</h1>
                <div class="grid gap-x-5 md:grid-cols-2">
                    <x-input-default-form type="text" name="first_name" :value="old('first_name')" id="first_name" labelTitle="Nama Depan*" error='first_name' placeholder="John"></x-input-default-form>
                    <x-input-default-form type="text" name="last_name" :value="old('last_name')" id="last_name" labelTitle="Nama Belakang" error='last_name' placeholder="Doe"></x-input-default-form>
                    <x-input-default-form type="email" name="email" :value="old('email')" id="email" labelTitle="Email*" error='email' placeholder="johndoe@mail.com"></x-input-default-form>
                    <x-input-default-form type="text" name="username" :value="old('username')" id="username" labelTitle="Username*" error='username' placeholder="johndoe123"></x-input-default-form>
                    <x-input-default-form type="text" name="address" :value="old('address')" id="address" labelTitle="Alamat*" error='address' placeholder="RT/RW 002/001, Desa Panggul, Kecamatan Panggul"></x-input-default-form>
                    <x-input-default-form type="text" name="phone_number" :value="old('phone_number')" id="phone_number" labelTitle="Nomor Handphone*" error='phone_number' placeholder="081234567889"></x-input-default-form>
                    <x-input-default-form type="password" name="password" id="password" labelTitle="Password*" error='password' placeholder="*********"></x-input-default-form>
                </div>

                <p class="mb-5 text-sm text-yellow-600">
                    <span><svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg></span>
                    Data diri hanya dapat diakses oleh pemilik akun dan super admin
                </p>
                <div class="flex gap-x-2">
                    <a href="{{ route('users.index') }}" class="text-white bg-gray-600 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Kembali</a>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
