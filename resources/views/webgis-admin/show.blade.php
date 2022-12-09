<x-app-layout>
    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-3 bg-white rounded-md shadow-lg border-1 border-slate-300">
                <div class="block ">
                    <div>
                        <div class="flex items-center justify-center my-5">
                            <div class="flex justify-center">
                                @if ($user->image_path)
                                <span><img class="flex items-center justify-center p-1 rounded-full w-28 h-28 ring-2 ring-gray-300" src="/docs/images/people/profile-picture-5.jpg" alt="Bordered avatar"></span>
                                @else
                                    <span class="flex items-center justify-center text-3xl font-medium text-gray-600 bg-gray-200 rounded-full w-28 h-28">{{ Str::substr($user->first_name, 0, 1) . Str::substr($user->last_name, 0, 1) }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center justify-center text-lg font-semibold text-gray-600">
                            {{ $user->full_name }}
                        </div>
                        <a href="{{ route('users.edit', ['user' => $user]) }}" class="flex items-center justify-center mt-2 text-sm text-blue-400 hover:underline hover:font-semibold">
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
                    <hr class="h-1 mx-5 my-4 bg-gray-200 border-0 rounded">
                    <div class="mx-5 text-black">
                        bbb
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
