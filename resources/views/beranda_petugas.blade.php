<x-layout>
    <h1 class="mb-2">Selamat datang di Aplikasi SIPETA</h1>

    <button id="trackingBtn"
        onclick="toggleTracking()"
        class="px-4 py-2 rounded cursor-pointer
            {{ $user->is_tracking ? 'bg-red-600 text-white' : 'bg-[#FF6600] text-white' }}">
        {{ $user->is_tracking ? 'Selesai' : 'Mulai' }}
    </button>

    <script>
        let trackingInterval = null;
        let isTracking = {{ $user->is_tracking ? 'true' : 'false' }};

        const button = document.getElementById("trackingBtn");

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

            isTracking = true;

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
            isTracking = false;

            button.textContent = "Mulai";
            button.classList.remove("bg-red-600");
            button.classList.add("bg-[#FF6600]");
        }

        function toggleTracking() {
            if (isTracking) {
                stopTracking();
            } else {
                startTracking();
            }
        }
    </script>

</x-layout>