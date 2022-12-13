<x-app-layout>
    <div class="py-8">
        <div class="static mx-auto max-w-7xl sm:px-6 lg:px-8">
            @include('components.alert')
            <div class="relative shadow-md sm:rounded-lg">
                <div class="px-5 pt-5 pb-10 text-lg font-semibold text-left text-gray-700 bg-white">
                    <h1>Kelola Data Administrator Sistem Informasi Geografis Wisata Trenggalek</h1>
                    <div class="justify-between block mt-2 md:flex">
                        <a href="{{ route('users.create') }}" type="button" class="py-2.5 w-2.5/12 px-2 mr-2 mb-2 mt-3 text-sm font-medium text-gray-700 focus:outline-none bg-gray-300 rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-500 focus:z-10 focus:ring-2 focus:ring-gray-200">Tambah Data Administrator</a>
                        <div class="h-10 mt-3 mb-2 w-2.5/12 md:w-5/12">
                            <form action="{{ route('users.search') }}" method="GET">
                                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                                <div class="relative w-full">
                                    <input type="search" name="search" id="search-dropdown" value="{{ request('search') }}" @keyup.enter="submit" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required placeholder="Cari nama" autocomplete="off">
                                    <button type="submit" class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        <span class="sr-only">Search</span>
                                    </button>
                                </div>
                            </form>
                            <a href="{{ route('users.index') }}" class="flex justify-end mt-3 text-sm text-blue-500 hover:underline">
                                Reset pencarian
                            </a>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    @if (!$users->count())
                        <div class="flex justify-center pt-10 font-semibold text-gray-500">
                            Data tidak tersedia
                        </div>
                    @else
                        <table class="relative w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nama
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Username
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Role
                                    </th>
                                    <th scope="col" class="flex justify-center px-6 py-3">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr class="bg-white border-b">
                                        <td class="px-6 py-4">
                                            {{ $key + $users->firstItem() }}
                                        </td>
                                        <td class="flex px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            <div class="relative inline-flex items-center justify-center w-10 h-10 mr-3 overflow-hidden bg-gray-100 rounded-full">
                                                @if ($user->avatar_path)
                                                    <span><img class="w-10 h-10 rounded-full" src="{{ asset('storage/avatars/' . $user->avatar_name) }}" alt="Bordered avatar"></span>
                                                @else
                                                    <span class="font-medium text-gray-600">{{ Str::substr($user->first_name, 0, 1) . Str::substr($user->last_name, 0, 1) }}</span>
                                                @endif
                                            </div>
                                            <div class="flex items-center">
                                                <a href="{{ route('users.show', ['user' => $user]) }}" class="hover:underline hover:underline-offset-4">{{ $user->full_name }}</a>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $user->username }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $user->email }}
                                        </td>
                                        <div>
                                            <td class="px-6 py-4">
                                            @if ($user->is_admin == 1)
                                                Super Admin
                                            @else
                                                Webgis Administrator
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($user->is_admin == 0)
                                                <x-action-button :value="$user->full_name" :href="route('users.edit', ['user' => $user])" :action="route('users.destroy', ['user' => $user])"/>
                                            @endif
                                        </td>
                                        </div>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="py-5 mx-10 mt-1">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
