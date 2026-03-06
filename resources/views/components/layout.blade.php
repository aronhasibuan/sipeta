<!DOCTYPE html>
<html lang="en" class="h-full bg-white dark:bg-gray-900">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi Pemantauan Petugas Lapangan">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>SIPETA (Sistem Informasi Pemantauan Petugas Lapangan BPS Kabupaten Deli Serdang)</title>

    @vite(['resources/css/app.css'])

    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.css" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="h-full font-sans">

    <div class="flex h-screen">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-[#FF6600] text-white flex flex-col">

            <div class="p-6 text-lg font-bold border-b border-orange-400">
                SIPETA
            </div>

            <nav class="flex-1 p-4 space-y-2">

                @if (Auth::check() && Auth::user()->is_admin)
                    <a href="/dashboard" class="block px-4 py-2 rounded-lg hover:bg-orange-500 transition">
                        Dashboard
                    </a>

                    <a href="{{ route('users.index') }}"
                        class="block px-4 py-2 rounded-lg hover:bg-orange-500 transition">
                        Manajemen Pengguna
                    </a>
                @else
                    <a href="{{ route('beranda_petugas') }}"
                        class="block px-4 py-2 rounded-lg hover:bg-orange-500 transition">
                        Beranda
                    </a>
                @endif

                <a href="{{ route('about') }}" class="block px-4 py-2 rounded-lg hover:bg-orange-500 transition">
                    About
                </a>

            </nav>

            <!-- LOGOUT -->
            <div class="p-4 border-t border-orange-400">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 rounded-lg hover:bg-orange-500 transition cursor-pointer">
                        Logout
                    </button>
                </form>
            </div>

        </aside>

        <!-- CONTENT -->
        <main class="flex-1 overflow-y-auto bg-gray-50">

            <div class="mx-auto max-w-7xl px-6 py-6">
                {{ $slot }}
            </div>

        </main>

    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
        @if (session('deleted'))
            toastr.info("{{ session('deleted') }}");
        @endif
        @if (session('updated'))
            toastr.success("{{ session('updated') }}");
        @endif
    </script>

</body>

</html>
