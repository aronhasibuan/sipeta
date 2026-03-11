<x-layout>

    <h1 class="text-2xl font-bold mb-4">Tambah Pengguna</h1>

    <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label>Nama</label>
            <input type="text" name="name" class="w-full border rounded p-2">
        </div>

        <div>
            <label>Kegiatan</label>
            <input type="text" name="kegiatan" class="w-full border rounded p-2">
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" class="w-full border rounded p-2">
        </div>

        <div>
            <label>Password</label>
            <input type="password" name="password" class="w-full border rounded p-2">
        </div>

        <button class="bg-[#FF6600] text-white px-4 py-2 rounded">
            Simpan
        </button>

    </form>

</x-layout>
