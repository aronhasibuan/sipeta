<x-layout>

    <div class="max-w-3xl mx-auto space-y-6">

        <!-- HEADER -->
        <div class="bg-white shadow rounded-xl p-6 text-center">

            <h1 class="text-2xl font-bold text-[#FF6600]">
                Aplikasi SIPETA
            </h1>

            <p class="text-gray-600 mt-1">
                Sistem Pemantauan Petugas Lapangan
            </p>

        </div>


        <!-- KEGIATAN -->
        <div class="bg-white shadow rounded-xl p-6">

            <h2 class="text-lg font-semibold mb-2">
                Kegiatan Hari Ini
            </h2>

            <p class="text-gray-700">
                {{ $user->kegiatan }}
            </p>

            <p class="mt-3 text-sm text-gray-500 italic">
                Jika kegiatan yang ingin dilakukan tidak sesuai, silakan hubungi admin untuk mengubah kegiatan.
            </p>

        </div>


        <!-- STATUS TRACKING -->
        <div class="bg-white shadow rounded-xl p-6 text-center space-y-4">

            <h2 class="text-lg font-semibold">
                Status Tracking
            </h2>

            <div id="statusText"
                class="text-lg font-semibold
            {{ $user->is_tracking ? 'text-green-600' : 'text-gray-500' }}">

                {{ $user->is_tracking ? 'Sedang Berjalan' : 'Belum Dimulai' }}

            </div>


            <!-- STOPWATCH -->

            <div>

                <p class="text-gray-500 text-sm">
                    Durasi Kegiatan
                </p>

                <div id="stopwatch" class="text-3xl font-bold text-[#FF6600] mt-1">

                    00:00:00

                </div>

            </div>


            <!-- BUTTON -->

            <button id="trackingBtn" onclick="toggleTracking()"
                class="px-6 py-3 rounded-lg text-white font-semibold transition
            {{ $user->is_tracking ? 'bg-red-600 hover:bg-red-700' : 'bg-[#FF6600] hover:bg-orange-600' }}">

                {{ $user->is_tracking ? 'Selesai' : 'Mulai' }}

            </button>

        </div>

    </div>



    <script>
        let trackingInterval = null;
        let stopwatchInterval = null;

        let isTracking = {{ $user->is_tracking ? 'true' : 'false' }};
        const button = document.getElementById("trackingBtn");
        const stopwatchEl = document.getElementById("stopwatch");
        const statusText = document.getElementById("statusText");

        let seconds = 0;


        function updateStopwatch() {

            seconds++;

            let hrs = String(Math.floor(seconds / 3600)).padStart(2, '0');
            let mins = String(Math.floor((seconds % 3600) / 60)).padStart(2, '0');
            let secs = String(seconds % 60).padStart(2, '0');

            stopwatchEl.textContent = `${hrs}:${mins}:${secs}`;

        }


        function startStopwatch() {

            stopwatchInterval = setInterval(updateStopwatch, 1000);

        }


        function stopStopwatch() {

            clearInterval(stopwatchInterval);
            stopwatchInterval = null;
            seconds = 0;

            stopwatchEl.textContent = "00:00:00";

        }


        function sendLocation(position) {

            fetch('/api/location', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude
                })
            });

        }


        function startTracking() {

            fetch('/tracking/start', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            navigator.geolocation.getCurrentPosition(sendLocation);

            const intervalMenit = 15;

            trackingInterval = setInterval(() => {
                navigator.geolocation.getCurrentPosition(sendLocation);
            }, intervalMenit * 60 * 1000);

            startStopwatch();

            isTracking = true;

            statusText.textContent = "Sedang Berjalan";
            statusText.classList.remove("text-gray-500");
            statusText.classList.add("text-green-600");

            button.textContent = "Selesai";
            button.classList.remove("bg-[#FF6600]");
            button.classList.add("bg-red-600");

        }


        function stopTracking() {

            fetch('/tracking/stop', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            clearInterval(trackingInterval);
            trackingInterval = null;

            stopStopwatch();

            isTracking = false;

            statusText.textContent = "Belum Dimulai";
            statusText.classList.remove("text-green-600");
            statusText.classList.add("text-gray-500");

            button.textContent = "Mulai";
            button.classList.remove("bg-red-600");
            button.classList.add("bg-[#FF6600]");

        }


        function toggleTracking() {

            if (isTracking) {

                Swal.fire({
                    title: 'Selesai Tracking?',
                    text: "Apakah Anda yakin ingin mengakhiri kegiatan?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Selesai',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        stopTracking();
                    }
                });

            } else {

                Swal.fire({
                    title: 'Mulai Tracking?',
                    text: "Tracking kegiatan akan dimulai.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#FF6600',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Mulai',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        startTracking();
                    }
                });

            }

        }
    </script>

</x-layout>
