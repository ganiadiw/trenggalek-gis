<x-app-layout>
    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="h-full py-5 bg-white rounded-md shadow-lg px-7 sm:px-10 border-1 border-slate-300">
                <div class="flex justify-center my-5">
                    <h1 class="text-lg font-semibold text-black">Detail Profil</h1>
                </div>

                <div>
                    <div class="flex justify-center">
                        @if ($user->avatar_name)
                            <img class="flex items-center justify-center w-32 h-32 p-1 rounded-full lg:w-44 lg:h-44"
                                src="{{ asset('storage/avatars/' . $user->avatar_name) }}" alt="Bordered avatar">
                        @else
                            <img class="flex items-center justify-center w-32 h-32 p-1 rounded-full lg:w-64 lg:h-64"
                                src="{{ Avatar::create($user->name)->setDimension(500, 500)->setFontSize(230)->toBase64() }}"
                                alt="{{ $user->name }}">
                        @endif
                    </div>
                    <div class="grid mb-5 justify-items-center">
                        <a href="{{ route('dashboard.users.edit', ['user' => $user]) }}"
                            class="flex mt-2 text-sm text-blue-400 hover:underline hover:font-semibold">
                            <span class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit"
                                    width="18" height="18" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                                    </path>
                                    <path d="M16 5l3 3"></path>
                                </svg>
                            </span>
                            Edit Profil
                        </a>
                    </div>
                    <div class="grid gap-x-5 md:grid-cols-2">
                        <x-input-default-form type="text" value="{{ $user->name }}" id="name"
                            labelTitle="Nama Lengkap" disabled="true"></x-input-default-form>
                        @if ($user->is_admin == 1)
                            <x-input-default-form type="text" value="Super Admin" labelTitle="Level Hak Akses"
                                disabled="true"></x-input-default-form>
                        @else
                            <x-input-default-form type="text" value="Webgis Administrator"
                                labelTitle="Level Hak Akses" disabled="true"></x-input-default-form>
                        @endif
                        <x-input-default-form type="email" value="{{ $user->email }}" id="email"
                            labelTitle="Email" disabled="true"></x-input-default-form>
                        <x-input-default-form type="text" value="{{ $user->username }}" id="username"
                            labelTitle="Username" disabled="true"></x-input-default-form>
                        <x-input-default-form type="text" value="{{ $user->address }}" id="address"
                            labelTitle="Alamat" disabled="true"></x-input-default-form>
                        <x-input-default-form type="text" value="{{ $user->phone_number }}" id="phone_number"
                            labelTitle="Nomor Handphone" disabled="true"></x-input-default-form>
                    </div>
                    <div class="my-3">
                        <button type="button" onclick="history.back()"
                            class="text-white bg-gray-600 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Kembali</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
