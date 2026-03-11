<!DOCTYPE html>
<html lang="en" class="h-full bg-white">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIPETA</title>

    @vite(['resources/css/app.css'])

    <style>
        /* turunkan layer kontrol leaflet */
        .leaflet-top,
        .leaflet-bottom {
            z-index: 10 !important;
        }

        /* khusus attribution */
        .leaflet-control-attribution {
            z-index: 10 !important;
        }

        /* container map */
        .leaflet-container {
            z-index: 1;
        }
    </style>

    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

</head>

<body class="h-full font-sans bg-gray-100">

    <div x-data="{ open: false }" class="flex h-screen overflow-hidden">


        <!-- OVERLAY MOBILE -->
        <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black/40 z-900 lg:hidden" @click="open=false">
        </div>


        <!-- SIDEBAR -->
        <aside :class="open ? 'translate-x-0' : '-translate-x-full'"
            class="fixed z-1000 lg:static lg:translate-x-0 w-64 bg-[#FF6600] text-white flex flex-col transition-transform duration-200 ease-in-out h-full">

            <!-- LOGO -->
            <div class="p-6 text-xl font-bold border-b border-orange-400 flex items-center justify-between">

                <span>SIPETA</span>

                <!-- CLOSE MOBILE -->
                <button class="lg:hidden text-white text-xl" @click="open=false">
                    ✕
                </button>

            </div>


            <!-- MENU -->
            <nav class="flex-1 p-4 space-y-2 text-sm">

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

                    <button type="submit" class="w-full text-left px-4 py-2 rounded-lg hover:bg-orange-500 transition">

                        Logout

                    </button>

                </form>

            </div>

        </aside>



        <!-- CONTENT AREA -->
        <div class="flex-1 flex flex-col overflow-hidden">


            <!-- TOPBAR MOBILE -->
            <header class="lg:hidden bg-white shadow flex items-center justify-between px-4 py-3">

                <button @click="open=true" class="text-gray-700 text-2xl">

                    ☰

                </button>

                <span class="font-bold text-[#FF6600]">
                    SIPETA
                </span>

            </header>


            <!-- PAGE CONTENT -->
            <main class="flex-1 overflow-y-auto">

                <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6">

                    {{ $slot }}

                </div>

            </main>


        </div>

    </div>


    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

</body>

</html>
