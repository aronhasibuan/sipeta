<x-layout>

    <h1 class="text-2xl font-bold mb-4">Manajemen Pengguna</h1>

    <a href="{{ route('users.create') }}" class="bg-[#FF6600] text-white px-4 py-2 rounded-lg">
        Tambah Pengguna
    </a>

    <div class="mt-4 bg-white shadow rounded-lg overflow-hidden">

        <table class="w-full text-left">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($users as $user)
                    <tr class="border-b">

                        <td class="p-3">{{ $user->name }}</td>
                        <td class="p-3">{{ $user->email }}</td>

                        <td class="p-3 flex gap-2">

                            <a href="{{ route('users.edit', $user->id) }}"
                                class="bg-blue-500 text-white px-3 py-1 rounded">
                                Edit
                            </a>

                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button class="bg-red-500 text-white px-3 py-1 rounded">
                                    Hapus
                                </button>

                            </form>

                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>

    </div>

</x-layout>
