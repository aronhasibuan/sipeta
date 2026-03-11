<x-layout>

    <div class="space-y-6">

        <!-- HEADER -->
        <div class="bg-white shadow rounded-xl p-4 md:p-6">

            <h1 class="text-center text-[#FF6600] text-xl md:text-3xl font-bold leading-snug">
                Sistem Pemantauan Monitoring Petugas Lapangan (SIPETA)
            </h1>

        </div>


        <!-- ============================= -->
        <!-- FILTER PETUGAS -->
        <!-- ============================= -->

        <div class="bg-white shadow rounded-xl p-4 md:p-5">

            <div class="flex items-center gap-3">

                <label class="font-semibold">
                    Pilih Petugas
                </label>

                <select id="petugasFilter"
                    class="border rounded-lg px-3 py-2 w-full sm:w-auto focus:ring-2 focus:ring-[#FF6600]">

                    <option value="all">Semua Petugas</option>

                    @foreach ($petugas as $p)
                        <option value="{{ $p->id }}">
                            {{ $p->is_tracking ? '🟢' : '🔴' }} {{ $p->name }}
                        </option>
                    @endforeach

                </select>

            </div>

        </div>


        <!-- ============================= -->
        <!-- MAP MONITORING -->
        <!-- ============================= -->

        <div class="bg-white shadow rounded-xl p-4">

            <h2 class="text-base md:text-lg font-semibold mb-3">
                Monitoring Lokasi Petugas
            </h2>

            <div id="map" class="h-75 sm:h-100 md:125 rounded-lg border"></div>

        </div>


        <!-- ============================= -->
        <!-- HISTORY SECTION -->
        <!-- ============================= -->

        <div class="bg-white shadow rounded-xl p-4 md:p-6">

            <h2 class="text-lg md:text-xl font-semibold mb-4">
                History Lokasi Petugas
            </h2>


            <!-- FILTER -->

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-5">

                <select id="user_id" class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#FF6600]">

                    <option value="">Pilih Petugas</option>

                    @foreach ($petugas as $p)
                        <option value="{{ $p->id }}">
                            {{ $p->name }}
                        </option>
                    @endforeach

                </select>

                <input type="date" id="date" class="border rounded-lg px-3 py-2">

                <button onclick="loadHistory()"
                    class="bg-[#FF6600] hover:bg-orange-600 text-white px-4 py-2 rounded-lg">

                    Lihat History

                </button>

                <button onclick="exportExcel()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">

                    Export Excel

                </button>

            </div>


            <!-- ============================= -->
            <!-- TABEL -->
            <!-- ============================= -->

            <div class="overflow-x-auto">

                <table class="w-full text-sm border rounded-lg overflow-hidden">

                    <thead>

                        <tr class="bg-gray-100 text-gray-700">

                            <th class="border px-2 md:px-3 py-2 text-left">No</th>
                            <th class="border px-2 md:px-3 py-2 text-left">Latitude</th>
                            <th class="border px-2 md:px-3 py-2 text-left">Longitude</th>
                            <th class="border px-2 md:px-3 py-2 text-left">Waktu</th>

                        </tr>

                    </thead>

                    <tbody id="tableBody">

                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">
                                Belum ada data
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>


            <!-- ============================= -->
            <!-- PAGINATION -->
            <!-- ============================= -->

            <div class="flex flex-wrap justify-center items-center gap-3 mt-5">

                <button onclick="prevPage()" class="px-4 py-1 bg-gray-200 hover:bg-gray-300 rounded">

                    Prev

                </button>

                <span id="pageInfo" class="px-4 py-1 bg-gray-100 rounded"></span>

                <button onclick="nextPage()" class="px-4 py-1 bg-gray-200 hover:bg-gray-300 rounded">

                    Next

                </button>

            </div>

        </div>


        <!-- ============================= -->
        <!-- MAP HISTORY -->
        <!-- ============================= -->

        <div class="bg-white shadow rounded-xl p-4">

            <h3 class="text-base md:text-lg font-semibold mb-3">
                Map History Petugas
            </h3>

            <div id="historyMap" class="h-75 sm:h-100 md:h-112.5 rounded-lg border"></div>

        </div>

    </div>



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
                                    .bindPopup(`
                                        <div style="min-width:150px">
                                            <b>${loc.user.name}</b><br>
                                            <span style="font-size:12px;color:gray">
                                                ${loc.user.kegiatan ?? 'Tidak ada kegiatan'}
                                            </span>
                                        </div>
                                    `);

                            }

                        });

                    });

            }

            loadLocations();

            setInterval(loadLocations, 5000);

        });
    </script>


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
