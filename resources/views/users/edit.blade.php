<x-layout>

    <h1 class="text-2xl font-bold mb-4">Edit Pengguna</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-4">

            <div>
                <label>Nama</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded p-2">
            </div>

            <div>
                <label>Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded p-2">
            </div>

            <button class="bg-[#FF6600] text-white px-4 py-2 rounded">
                Update
            </button>

        </div>

    </form>

</x-layout>
