<x-app-layout>
    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="h-screen py-5 bg-white rounded-md shadow-lg px-7 sm:px-10 border-1 border-slate-300">
                <div class="flex justify-center my-5">
                    <h1 class="text-lg font-semibold text-black">Profil</h1>
                </div>
                <div class="lg:flex">
                    <div class="lg:w-2/6">
                        <div class="flex justify-center mb-5">
                        @if ($user->avatar_name)
                            <span><img class="flex items-center justify-center w-32 h-32 p-1 rounded-lg lg:w-44 lg:h-44" src="{{ asset('storage/avatars/' . $user->avatar_name) }}" alt="Bordered avatar"></span>
                            @else
                                <span class="flex items-center justify-center text-3xl font-medium text-gray-600 bg-gray-200 rounded-full lg:w-52 lg:h-52 w-28 h-28">{{ Str::substr($user->first_name, 0, 1) . Str::substr($user->last_name, 0, 1) }}</span>
                            @endif
                        </div>
                        <div class="hidden justify-items-center lg:grid">
                            <p class="text-xl font-semibold text-black">{{ $user->full_name }}</p>
                            @if ($user->is_admin == 1)
                                <p class="mt-2 font-semibold text-gray-700">Super Admin</p>
                            @else
                                <p class="mt-2 font-semibold text-gray-700">Webgis Administrator</p>
                            @endif
                            <a href="{{ route('users.edit', ['user' => $user]) }}" class="flex mt-2 text-sm text-blue-400 hover:underline hover:font-semibold">
                                <span class="mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                        <path d="M16 5l3 3"></path>
                                     </svg>
                                </span>
                                Edit Profil
                            </a>
                        </div>
                        <div class="lg:hidden">
                            <div class="grid justify-items-center">
                                <p class="text-xl font-semibold text-black">{{ $user->full_name }}</p>
                                @if ($user->is_admin == 1)
                                    <p class="mt-2 font-semibold text-gray-700">Super Admin</p>
                                @else
                                    <p class="mt-2 font-semibold text-gray-700">Webgis Administrator</p>
                                @endif
                                <a href="{{ route('users.edit', ['user' => $user]) }}" class="flex mt-2 text-sm text-blue-400 hover:underline hover:font-semibold">
                                    <span class="mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                            <path d="M16 5l3 3"></path>
                                         </svg>
                                    </span>
                                    Edit Profil
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-10 lg:w-4/6 lg:pl-5 lg:mt-0">

                        <div class="mb-3">
                            <h2 class="font-semibold text-black">Nama Depan</h2>
                            <p class="text-gray-700">{{ $user->first_name }}</p>
                        </div>
                        <div class="mb-3">
                            <h2 class="font-semibold text-black">Nama Belakang</h2>
                            <p class="text-gray-700">{{ $user->last_name }}</p>
                        </div>
                        <div class="mb-3">
                            <h2 class="font-semibold text-black">Username</h2>
                            <p class="text-gray-700">{{ $user->username }}</p>
                        </div>
                        <div class="mb-3">
                            <h2 class="font-semibold text-black">Email</h2>
                            <p class="text-gray-700">{{ $user->email }}</p>
                        </div>
                        <div class="mb-3">
                            <h2 class="font-semibold text-black">Alamat</h2>
                            <p class="text-gray-700">{{ $user->address }}</p>
                        </div>
                        <div class="mb-3">
                            <h2 class="font-semibold text-black">Nomor Handphone</h2>
                            <p class="text-gray-700">{{ $user->phone_number }}</p>
                        </div>
                    </div>
                </div>

                {{-- {{ $user->first_name }}
                {{ $user->last_name }}
                {{ $user->username }}
                {{ $user->email }} --}}
            </div>
        </div>
    </div>
</x-app-layout>
