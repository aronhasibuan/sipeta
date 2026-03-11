<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login SIPETA</title>

    @vite('resources/css/app.css')

    <!-- FONT -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- TOASTR -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" />

</head>

<body class="bg-linear-to-br from-orange-100 via-white to-orange-200 font-sans">

    <div class="min-h-screen flex items-center justify-center px-4">

        <div class="grid md:grid-cols-2 bg-white shadow-2xl rounded-2xl overflow-hidden max-w-4xl w-full">

            <!-- LEFT SIDE -->
            <div class="hidden md:flex flex-col items-center justify-center bg-[#FF6600] text-white p-10">

                <img src="{{ asset('img/Logo SIPETA.png') }}" class="w-24 mb-4">

                <h2 class="text-2xl font-bold text-center">
                    SIPETA
                </h2>

                <p class="text-center mt-2 text-sm opacity-90">
                    Sistem Informasi Pemantauan
                    <br>
                    Petugas Lapangan
                </p>

            </div>


            <!-- LOGIN FORM -->
            <div class="p-8">

                <h1 class="text-2xl font-bold text-gray-800 mb-2">
                    Masuk ke Sistem
                </h1>

                <p class="text-gray-500 text-sm mb-6">
                    Silakan login menggunakan akun Anda
                </p>

                <form action="{{ route('authenticate') }}" method="POST" class="space-y-5" autocomplete="off">
                    @csrf

                    <!-- EMAIL -->
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Alamat Email
                        </label>

                        <input type="email" name="email" placeholder="email@gmail.com"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#FF6600] focus:outline-none">

                    </div>


                    <!-- PASSWORD -->
                    <div>

                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Kata Sandi
                        </label>

                        <div class="relative">

                            <input type="password" name="password" id="password" placeholder="••••••••"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 pr-10 focus:ring-2 focus:ring-[#FF6600] focus:outline-none">

                            <i id="togglePassword"
                                class="fa-solid fa-eye absolute right-3 top-3 cursor-pointer text-gray-500">
                            </i>

                        </div>

                    </div>


                    <!-- BUTTON -->
                    <button type="submit"
                        class="w-full bg-[#FF6600] hover:bg-orange-600 text-white py-2.5 rounded-lg font-semibold transition">

                        Login

                    </button>

                </form>

            </div>

        </div>

    </div>


    <!-- SCRIPTS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "4000"
        };

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

        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function() {

            const type = password.getAttribute('type') === 'password' ?
                'text' :
                'password';

            password.setAttribute('type', type);

            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');

        });
    </script>

</body>

</html>
