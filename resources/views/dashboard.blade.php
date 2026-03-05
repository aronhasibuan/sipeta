<x-layout>

    <h1 class="text-center text-[#FF6600] text-2xl font-bold mb-5">
        Sistem Pemantauan Monitoring Petugas Lapangan (SIPETA)
    </h1>

    <!-- ============================= -->
    <!-- FILTER PETUGAS -->
    <!-- ============================= -->

    <div class="mb-4">
        <label class="font-semibold mr-2">Pilih Petugas:</label>
        <select id="petugasFilter" class="border rounded px-3 pr-10 py-1">
            <option value="all">Semua Petugas</option>
            @foreach ($petugas as $p)
                <option value="{{ $p->id }}">
                    {{ $p->is_tracking ? '🟢' : '🔴' }} {{ $p->name }}
                </option>
            @endforeach

        </select>

    </div>

    <!-- ============================= -->
    <!-- MAP MONITORING -->
    <!-- ============================= -->

    <div id="map" style="height:500px;"></div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            var map = L.map('map').setView([3.5350, 98.8640], 11);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            let markers = {};
            let selectedPetugas = "all";

            document.getElementById("petugasFilter")
                .addEventListener("change", function() {

                    selectedPetugas = this.value;

                    loadLocations();

                });

            function loadLocations() {

                fetch('/api/latest-locations')
                    .then(res => res.json())
                    .then(data => {

                        if (selectedPetugas !== "all") {

                            data = data.filter(loc =>
                                loc.user_id == selectedPetugas
                            );

                        }

                        let activeUserIds = data.map(loc => loc.user_id);

                        Object.keys(markers).forEach(userId => {

                            if (!activeUserIds.includes(parseInt(userId))) {

                                map.removeLayer(markers[userId]);
                                delete markers[userId];

                            }

                        });

                        data.forEach(loc => {

                            let lat = parseFloat(loc.latitude);
                            let lng = parseFloat(loc.longitude);

                            if (markers[loc.user_id]) {

                                markers[loc.user_id].setLatLng([lat, lng]);

                            } else {

                                markers[loc.user_id] = L.marker([lat, lng])
                                    .addTo(map)
                                    .bindPopup(loc.user.name);

                            }

                        });

                    });

            }

            loadLocations();

            setInterval(loadLocations, 5000);

        });
    </script>


    <!-- ============================= -->
    <!-- HISTORY FILTER -->
    <!-- ============================= -->

    <h2 class="text-lg font-semibold mt-8 mb-3">
        History Lokasi Petugas
    </h2>

    <div class="flex gap-4 mb-4">

        <select id="user_id" class="border p-2 rounded">

            <option value="">Pilih Petugas</option>

            @foreach ($petugas as $p)
                <option value="{{ $p->id }}">
                    {{ $p->name }}
                </option>
            @endforeach

        </select>

        <input type="date" id="date" class="border p-2 rounded">

        <button onclick="loadHistory()" class="bg-blue-500 text-white px-4 py-2 rounded">
            Lihat History
        </button>

        <button onclick="exportExcel()" class="bg-green-500 text-white px-3 py-1 rounded">
            Export Excel
        </button>

    </div>


    <!-- ============================= -->
    <!-- TABEL HISTORY -->
    <!-- ============================= -->

    <table class="table-auto w-full border">

        <thead>

            <tr class="bg-gray-200">
                <th class="border px-2 py-1">No</th>
                <th class="border px-2 py-1">Latitude</th>
                <th class="border px-2 py-1">Longitude</th>
                <th class="border px-2 py-1">Waktu</th>
            </tr>

        </thead>

        <tbody id="tableBody">

            <tr>
                <td colspan="4" class="text-center py-3">
                    Belum ada data
                </td>
            </tr>

        </tbody>

    </table>


    <!-- ============================= -->
    <!-- PAGINATION -->
    <!-- ============================= -->

    <div class="flex justify-center gap-2 mt-4">

        <button onclick="prevPage()" class="px-3 py-1 bg-gray-300 rounded">
            Prev
        </button>

        <span id="pageInfo" class="px-3 py-1"></span>

        <button onclick="nextPage()" class="px-3 py-1 bg-gray-300 rounded">
            Next
        </button>

    </div>


    <!-- ============================= -->
    <!-- MAP HISTORY -->
    <!-- ============================= -->

    <h3 class="text-lg font-semibold mt-6 mb-2">
        Map History Petugas
    </h3>

    <div id="historyMap" style="height:400px;"></div>


    <script>
        let historyData = [];
        let currentPage = 1;
        let rowsPerPage = 10;

        let historyMap;
        let historyPolyline;
        let historyMarkers = [];

        document.addEventListener("DOMContentLoaded", function() {

            historyMap = L.map('historyMap').setView([3.535, 98.673], 11);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(historyMap);

        });

        function loadHistory() {

            let user_id = document.getElementById('user_id').value;
            let date = document.getElementById('date').value;

            if (!user_id || !date) {

                alert("Pilih petugas dan tanggal terlebih dahulu");
                return;

            }

            fetch(`/api/history-locations?user_id=${user_id}&date=${date}`)
                .then(res => res.json())
                .then(data => {

                    historyData = data;
                    currentPage = 1;

                    renderTable();
                    renderMap();

                });

        }

        function renderTable() {

            let table = "";

            let start = (currentPage - 1) * rowsPerPage;
            let end = start + rowsPerPage;

            let pageData = historyData.slice(start, end);

            if (pageData.length === 0) {

                table = `
                    <tr>
                    <td colspan="4" class="text-center py-3">
                    Tidak ada data
                    </td>
                    </tr>
                    `;

            } else {

                pageData.forEach((loc, i) => {

                    table += `
                        <tr>
                        <td class="border px-2">${start + i + 1}</td>
                        <td class="border px-2">${loc.latitude}</td>
                        <td class="border px-2">${loc.longitude}</td>
                        <td class="border px-2">${loc.recorded_at}</td>
                        </tr>
                        `;

                });

            }

            document.getElementById("tableBody").innerHTML = table;

            updatePageInfo();

        }

        function renderMap() {

            let coords = [];

            historyMarkers.forEach(marker => historyMap.removeLayer(marker));
            historyMarkers = [];

            if (historyPolyline) {
                historyMap.removeLayer(historyPolyline);
            }

            historyData.forEach((loc, index) => {

                let lat = parseFloat(loc.latitude);
                let lng = parseFloat(loc.longitude);

                coords.push([lat, lng]);

                let marker = L.marker([lat, lng]).addTo(historyMap);

                if (index === 0) {
                    marker.bindPopup("Start").openPopup();
                }

                if (index === historyData.length - 1) {
                    marker.bindPopup("Finish");
                }

                historyMarkers.push(marker);

            });

            if (coords.length > 0) {

                historyPolyline = L.polyline(coords, {
                    color: 'blue',
                    weight: 4
                }).addTo(historyMap);

                historyMap.fitBounds(historyPolyline.getBounds(), {
                    padding: [40, 40]
                });

            }

        }

        function nextPage() {

            if ((currentPage * rowsPerPage) < historyData.length) {

                currentPage++;
                renderTable();

            }

        }

        function prevPage() {

            if (currentPage > 1) {

                currentPage--;
                renderTable();

            }

        }

        function updatePageInfo() {

            let totalPage = Math.ceil(historyData.length / rowsPerPage);

            document.getElementById("pageInfo").innerText =
                `Page ${currentPage} / ${totalPage || 1}`;

        }

        function exportExcel() {

            let user_id = document.getElementById('user_id').value;
            let date = document.getElementById('date').value;

            if (!user_id || !date) {

                alert("Pilih petugas dan tanggal terlebih dahulu");

                return;

            }

            window.location.href = `/export-history?user_id=${user_id}&date=${date}`;

        }
    </script>

</x-layout>
