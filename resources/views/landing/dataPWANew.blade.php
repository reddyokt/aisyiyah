@extends('layouts-landing.master')

@section('title', "Data Pimpinan Cabang 'Aisyiyah")

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 600px;
        }

        .legend {
            background: white;
            line-height: 18px;
            padding: 6px;
            font-size: 12px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            border-radius: 5px;
        }

        .legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin-right: 8px;
            opacity: 0.7;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-4 mb-10">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white mb-5">
                <h5 class="mb-0">Visualisasi Data PWA DKI Jakarta</h5>
            </div>
            <div class="card-body p-0">
                <div class="pda-grafik mb-5">
                    <canvas id="chartPDA" height="400"></canvas>
                </div>
                {{-- <div id="map"></div> --}}
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('chartPDA').getContext('2d');

            const labels = {!! json_encode($data->pluck('pda_name')) !!};
            const values = {!! json_encode($data->pluck('total_pca')) !!};
            const pdaIds = {!! json_encode($data->pluck('pda_id')) !!};

            const solidColors = [
                '#FF00FF', '#ffff7f', '#ffbf7f', '#ff7f7f',
                '#7fff7f', '#7fbfff', '#64B5F6', '#81C784',
                '#FF8A65', '#F48FB1'
            ];

            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah PCA',
                        data: values,
                        backgroundColor: labels.map((_, i) => solidColors[i % solidColors.length]),
                        borderColor: labels.map((_, i) => solidColors[i % solidColors.length]),
                        borderWidth: 1,
                        barPercentage: 0.8,
                        categoryPercentage: 0.9
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000,
                        easing: 'easeOutQuart'
                    },
                    hover: {
                        mode: 'nearest', // tetap bisa klik
                        animationDuration: 0
                    },
                    interaction: {
                        mode: 'nearest',
                        intersect: true
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    onClick: (evt, activeEls) => {
                        if (activeEls.length > 0) {
                            const index = activeEls[0].index;
                            const pdaId = pdaIds[index];
                            const url = `/detail/pda/${pdaId}`;
                            window.open(url, '_blank'); // buka di tab baru
                        }
                    }
                }
            });
        });
    </script>

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            var map = L.map('map').setView([-6.2088, 106.8456], 10);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            const geoFiles = [{
                    url: "{{ asset('geojson/31.01_Administrasi_Kepulauan_Seribu.geojson') }}",
                    name: "Kepulauan Seribu",
                    color: "#FF00FF"
                },
                {
                    url: "{{ asset('geojson/31.71_Kota_Administrasi_Jakarta_Pusat.geojson') }}",
                    name: "Jakarta Pusat",
                    color: "#ff7f7f"
                },
                {
                    url: "{{ asset('geojson/31.72_Kota_Administrasi_Jakarta_Utara.geojson') }}",
                    name: "Jakarta Utara",
                    color: "#7fbfff"
                },
                {
                    url: "{{ asset('geojson/31.73_Kota_Administrasi_Jakarta_Barat.geojson') }}",
                    name: "Jakarta Barat",
                    color: "#7fff7f"
                },
                {
                    url: "{{ asset('geojson/31.74_Kota_Administrasi_Jakarta_Selatan.geojson') }}",
                    name: "Jakarta Selatan",
                    color: "#ffff7f"
                },
                {
                    url: "{{ asset('geojson/31.75_Kota_Administrasi_Jakarta_Timur.geojson') }}",
                    name: "Jakarta Timur",
                    color: "#ffbf7f"
                },
            ];

            // Layer group untuk menggabungkan semua kota
            let jakartaLayerGroup = L.featureGroup();

            // Load semua GeoJSON
            geoFiles.forEach(g => {
                fetch(g.url)
                    .then(response => response.json())
                    .then(data => {
                        const layer = L.geoJson(data, {
                            style: {
                                fillColor: g.color,
                                weight: 2,
                                opacity: 1,
                                color: 'white',
                                dashArray: '3',
                                fillOpacity: 0.7
                            },
                            onEachFeature: (feature, layer) => {
                                layer.bindPopup(`<b>${g.name}</b>`);
                            }
                        });
                        jakartaLayerGroup.addLayer(layer);
                    });
            });

            // Setelah semua data selesai dimuat, fokuskan peta
            setTimeout(() => {
                jakartaLayerGroup.addTo(map);
                map.fitBounds(jakartaLayerGroup.getBounds());
            }, 1500);

            // Legend
            var legend = L.control({
                position: 'bottomright'
            });
            legend.onAdd = function() {
                var div = L.DomUtil.create('div', 'legend');
                geoFiles.forEach(g => {
                    div.innerHTML += `<i style="background:${g.color}"></i> ${g.name}<br>`;
                });
                return div;
            };
            legend.addTo(map);
        });
    </script> --}}
@endsection
