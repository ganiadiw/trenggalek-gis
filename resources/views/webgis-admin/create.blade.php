<x-app-layout>
    <div>
        <div class="px-4 py-4 mx-auto text-gray-900 max-w-7xl sm:px-6 lg:px-8">
            <div class="px-8 py-6 mt-5 bg-white border-2 rounded-md shadow-lg">
                <h1 class="w-full text-lg font-bold">Tambah Data Administrator</h1>
                <div class="w-full mt-5">
                    <form method="POST" action="{{ route('dashboard.users.store') }}">
                        @csrf
                        <div class="grid gap-5 lg:grid-cols-2">
                            <div>
                                <h2 class="text-base font-semibold text-gray-800">Data Diri</h2>
                                <div class="p-5 mt-3 border-2 border-gray-200 rounded-md shadow-md">
                                    <x-input-default-form type="text" name="name" :value="old('name')" id="name"
                                        labelTitle="Nama Lengkap*" error='name' placeholder="Nama Lengkap">
                                    </x-input-default-form>
                                    <x-input-default-form type="email" name="email" :value="old('email')" id="email"
                                        labelTitle="Email*" error='email' placeholder="Email Valid">
                                    </x-input-default-form>
                                    <x-input-default-form type="text" name="username" :value="old('username')"
                                        id="username" labelTitle="Username*" error='username' placeholder="Username">
                                    </x-input-default-form>
                                    <x-input-default-form type="text" name="address" :value="old('address')" id="address"
                                        labelTitle="Alamat*" error='address'
                                        placeholder="Alamat Lengkap">
                                    </x-input-default-form>
                                    <x-input-default-form type="text" name="phone_number" :value="old('phone_number')"
                                        id="phone_number" labelTitle="Nomor Handphone*" error='phone_number'
                                        placeholder="Nomor Handphone">
                                    </x-input-default-form>
                                </div>
                            </div>
                            <div>
                                <h2 class="font-semibold">Kata Sandi</h2>
                                <div class="p-5 mt-3 border-2 border-gray-200 rounded-md shadow-md">
                                    <div>
                                        <x-input-default-form type="password" name="password" id="password"
                                            labelTitle="Kata Sandi" error='password' placeholder="*********">
                                        </x-input-default-form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <blockquote class="p-2 mt-4 bg-gray-100 border-l-4 border-yellow-300 rounded-sm">
                            <p class="text-[13px] font-medium italic leading-relaxed text-yellow-500">
                                Data diri hanya dapat diakses oleh pemilik akun dan super admin
                            </p>
                        </blockquote>
                        <div class="flex justify-end mt-8 gap-x-2">
                            <button onclick="history.back()"
                                class="text-white bg-gray-600 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Kembali</button>
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
