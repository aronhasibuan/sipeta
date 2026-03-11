<x-layout>

    <div class="space-y-4">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

            <h1 class="text-xl md:text-2xl font-bold">
                Manajemen Pengguna
            </h1>

            <a href="{{ route('users.create') }}"
                class="bg-[#FF6600] text-white px-4 py-2 rounded-lg text-center w-full sm:w-auto">
                Tambah Pengguna
            </a>

        </div>


        <!-- TABLE -->

        <div class="bg-white shadow rounded-lg overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-sm md:text-base text-left">

                    <thead class="bg-gray-100">

                        <tr>
                            <th class="px-3 py-2 md:px-4 md:py-3">Nama</th>
                            <th class="px-3 py-2 md:px-4 md:py-3">Email</th>
                            <th class="px-3 py-2 md:px-4 md:py-3">Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($users as $user)
                            <tr class="border-b hover:bg-gray-50">

                                <td class="px-3 py-2 md:px-4 md:py-3 font-medium">
                                    {{ $user->name }}
                                </td>

                                <td class="px-3 py-2 md:px-4 md:py-3 text-gray-600 break-all">
                                    {{ $user->email }}
                                </td>

                                <td class="px-3 py-2 md:px-4 md:py-3">

                                    <div class="flex flex-wrap gap-2">

                                        <a href="{{ route('users.edit', $user->id) }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">

                                            Edit

                                        </a>

                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">

                                                Hapus

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-layout>
