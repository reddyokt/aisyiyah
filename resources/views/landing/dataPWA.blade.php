@extends('layouts-landing.master')

@section('title')
    Data Pimpinan Cabang 'Aisyiyah
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
@endsection

@section('content')
    <div class="container mt-4 mb-10">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Visualisasi Data PWA DKI JAKARTA</h5>
            </div>

            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body" style="height: 500px;"> <!-- sebelumnya 500px -->
                        <canvas id="pcaChart"></canvas>
                        <button class="btn btn-sm btn-outline-primary mt-3"
                            onclick="downloadChart('pcaChart', 'pca_dki')">Download Chart</button>
                    </div>
                </div>
            </div>

            <hr>
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body" style="height: 500px;">
                        <canvas id="rantingChartJakpus"></canvas>
                        <button class="btn btn-sm btn-outline-primary mb-3"
                            onclick="downloadChart('rantingChartJakpus', 'ranting_Jakpus')">Download Chart</button>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body" style="height: 500px;">
                        <canvas id="rantingChartJaksel"></canvas>
                        <button class="btn btn-sm btn-outline-primary mb-3"
                            onclick="downloadChart('rantingChartJaksel', 'ranting_Jaksel')">Download Chart</button>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body" style="height: 500px;">
                        <canvas id="rantingChartJakbar"></canvas>
                        <button class="btn btn-sm btn-outline-primary mb-3"
                            onclick="downloadChart('rantingChartJakbar', 'ranting_Jakbar')">Download Chart</button>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body" style="height: 500px;">
                        <canvas id="aumJakpusChart"></canvas>
                        <button class="btn btn-sm btn-outline-primary mb-3"
                            onclick="downloadChart('aumJakpusChart', 'aum_Jakpus')">Download Chart</button>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body" style="height: 500px;">
                        <canvas id="aumJakselChart"></canvas>
                        <button class="btn btn-sm btn-outline-primary mb-3"
                            onclick="downloadChart('aumJakselChart', 'aum_Jaksel')">Download Chart</button>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body" style="height: 500px;">
                        <canvas id="aumJaktimChart"></canvas>
                        <button class="btn btn-sm btn-outline-primary mb-3"
                            onclick="downloadChart('aumJaktimChart', 'aum_Jaktim')">Download Chart</button>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body" style="height: 500px;">
                        <canvas id="aumJakbarChart"></canvas>
                        <button class="btn btn-sm btn-outline-primary mb-3"
                            onclick="downloadChart('aumJakbarChart', 'aum_Jakbar')">Download Chart</button>
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body" style="height: 500px;">
                        <canvas id="aumJakutChart"></canvas>
                        <button class="btn btn-sm btn-outline-primary mb-3"
                            onclick="downloadChart('aumJakutChart', 'aum_Jakut')">Download Chart</button>
                    </div>
                </div>
            </div>
            <hr>

            <div class="col-12 table-responsive">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="text-center">Data ASET PWA DKI JAKARTA</h3>
                        <table class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>PDA</th>
                                    <th>Kategori</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td rowspan="6">PDA Jakarta Pusat</td>
                                    <td rowspan="4">Gedung</td>
                                    <td>Gedung Dakwah Aisyiyah Jakarta Pusat</td>
                                    <td>Jl. Salemba Bluntas I Nomor 77</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Jl. Kebon Kosong Gg.25</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Jl. Pancamarga I No 8</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Jl. Gedung Dakwah Aisyiyah Jl Petojo Roxy Mas Jakarta Pusat</td>
                                </tr>
                                <tr>
                                    <td>Masjid Dan Mushallah Aisyiyah</td>
                                    <td>Masjid Aisyiyah Petojo VIY II Roxy Mas</td>
                                    <td>Jl. Tegal Rorotan Roxymas</td>
                                </tr>
                                <tr>
                                    <td>Masjid Dan Mushallah Aisyiyah</td>
                                    <td>Mushola Aisyiyah utan Panjang</td>
                                    <td>Jl. Kali Baru Timur 6 Gg. 14 No. 578 RT4/RW9, Utan Panjang, Kecamatan Kemayoran,
                                        Kota Jakarta Pusat. DKI Jakarta 10650</td>
                                </tr>
                                <tr>
                                    <td rowspan="3">PDA Jakarta Selatan</td>
                                    <td>Gedung</td>
                                    <td>Panti Asuhan Putri</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Gedung</td>
                                    <td>Balai Kesehatan Masyarakat</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Gedung</td>
                                    <td>Rumah Singgah Aisyiyah</td>
                                    <td>PCA Bukit Duri</td>
                                </tr>
                                <tr>
                                    <td>PDA Jakarta Timur</td>
                                    <td>Gedung</td>
                                    <td>Gedung PDA Jakarta Timur</td>
                                    <td>Duren Sawit</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('pcaChart').getContext('2d');

        const pcaChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    'PDA Jakarta Pusat',
                    'PDA Jakarta Selatan',
                    'PDA Jakarta Barat',
                    'PDA Jakarta Timur',
                    'PDA Jakarta Utara',
                    'PDA Kepulauan Seribu'
                ],
                datasets: [{
                    label: 'Jumlah PDA',
                    data: [13, 13, 13, 11, 11, 3],
                    backgroundColor: 'rgba(144, 238, 144, 0.8)', // light green
                    borderColor: 'rgba(0, 128, 0, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Cabang'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Wilayah PDA'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: "Data Pimpinan Cabang 'Aisyiyah",
                        font: {
                            size: 18
                        }
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
    <script>
        const ctxRanting = document.getElementById('rantingChartJakpus').getContext('2d');

        const rantingChart = new Chart(ctxRanting, {
            type: 'bar',
            data: {
                labels: [
                    'PCA Tanah Abang I',
                    'PCA Tanah Abang II',
                    'PCA Tanah Abang III',
                    'PCA Tanah Abang IV',
                    'PCA Gambir',
                    'PCA Sawah Besar',
                    'PCA Kemayoran I',
                    'PCA Kemayoran II',
                    'PCA Senen',
                    'PCA Kramat',
                    'PCA Cempaka Putih',
                    'PCA Johar Baru',
                    'PCA Menteng'
                ],
                datasets: [{
                    label: 'Jumlah Ranting',
                    data: [6, 4, 4, 7, 3, 3, 3, 3, 3, 4, 3, 4, 3],
                    backgroundColor: 'rgba(144, 238, 144, 0.8)', // hijau muda
                    borderColor: 'rgba(0, 128, 0, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y', // membuat bar horizontal
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: "Jumlah Ranting PCA Jakarta Pusat",
                        font: {
                            size: 16
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Ranting'
                        }
                    },
                    y: {
                        ticks: {
                            autoSkip: false
                        }
                    }
                }
            }
        });
    </script>
    <script>
        const ctxJaksel = document.getElementById('rantingChartJaksel').getContext('2d');
        new Chart(ctxJaksel, {
            type: 'bar',
            data: {
                labels: [
                    'PCA Cipedak', 'PCA Pasar Minggu', 'PCA Cilandak', 'PCA Kebayoran Lama',
                    'PCA Kebayoran Baru Barat', 'PCA Kebayoran Baru Timur', 'PCA Tebet Barat',
                    'PCA Tebet Timur', 'PCA Kebon Baru', 'PCA Bukit Duri', 'PCA Setia Budi',
                    'PCA Pasar Manggis', 'PCA Pasar Rumput'
                ],
                datasets: [{
                    label: 'Jumlah Ranting',
                    data: [4, 5, 2, 5, 2, 3, 2, 5, 5, 5, 4, 0, 4],
                    backgroundColor: '#4caf50'
                }]
            },
            options: {
                indexAxis: 'y', // horizontal bar chart
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: "Jumlah Ranting PCA Jakarta Selatan",
                        font: {
                            size: 16
                        }
                    },
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: context => `Jumlah: ${context.raw}`
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah'
                        }
                    },
                    y: {
                        ticks: {
                            autoSkip: false,
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });
    </script>
    <script>
        const ctxJakbar = document.getElementById('rantingChartJakbar').getContext('2d');
        new Chart(ctxJakbar, {
            type: 'bar',
            data: {
                labels: [
                    'PCA Cengkareng', 'PCA Tomang', 'PCA Grogol', 'PCA Slipi Komplek',
                    'PCA Tambora', 'PCA Jatipulo', 'PCA Slipi Kota Bambu', 'PCA Palmerah',
                    'PCA Kebon Jeruk', 'PCA Kota', 'PCA Tanjung Duren', 'PCA Kembangan', 'PCA Jelambar'
                ],
                datasets: [{
                    label: 'Jumlah Ranting',
                    data: [4, 3, 4, 3, 0, 0, 3, 0, 4, 0, 0, 2, 1],
                    backgroundColor: '#4caf50'
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: "Jumlah Ranting PCA Jakarta Barat",
                        font: {
                            size: 16
                        }
                    },
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: context => `Jumlah: ${context.raw}`
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah'
                        }
                    },
                    y: {
                        ticks: {
                            autoSkip: false,
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });
    </script>
    <script>
        function downloadChart(canvasId, filename) {
            const link = document.createElement('a');
            link.download = filename + '.png';
            const canvas = document.getElementById(canvasId);
            link.href = canvas.toDataURL('image/png', 1.0);
            link.click();
        }
    </script>
    <script>
        const ctxJakpus = document.getElementById('aumJakpusChart').getContext('2d');
        new Chart(ctxJakpus, {
            type: 'bar',
            data: {
                labels: [
                    'TK ABA',
                    'Madrasah Diniyah Aisyiyah',
                    'RA Aisyiyah',
                    'SPS Aisyiyah'
                ],
                datasets: [{
                    label: 'Jumlah AUM',
                    data: [15, 4, 1, 1],
                    backgroundColor: [
                        '#4e73df',
                        '#1cc88a',
                        '#36b9cc',
                        '#f6c23e'
                    ],
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: "Jumlah AUM di PDA Jakarta Pusat",
                        font: {
                            size: 16
                        }
                    },
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: context => `Jumlah: ${context.raw}`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
    <script>
        const ctxAumJaksel = document.getElementById('aumJakselChart').getContext('2d');
        new Chart(ctxAumJaksel, {
            type: 'bar',
            data: {
                labels: [
                    'TK ABA',
                    'TPQ Aisyiyah',
                    'Madrasah Diniyah Aisyiyah',
                    'PAUD Aisyiyah',
                    'TPA Aisyiyah',
                    'SD Diniyah Aisyiyah',
                    'Panti Asuhan Putri'
                ],
                datasets: [{
                    label: 'Jumlah AUM',
                    data: [26, 7, 3, 2, 1, 1, 1],
                    backgroundColor: [
                        '#4e73df',
                        '#1cc88a',
                        '#36b9cc',
                        '#f6c23e',
                        '#e74a3b',
                        '#858796',
                        '#2e59d9'
                    ],
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: "Jumlah AUM di PDA Jakarta Selatan",
                        font: {
                            size: 16
                        }
                    },
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: context => `Jumlah: ${context.raw}`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
    <script>
        const ctxAumJaktim = document.getElementById('aumJaktimChart').getContext('2d');
        new Chart(ctxAumJaktim, {
            type: 'bar',
            data: {
                labels: [
                    'TK ABA',
                    'Pengajian',
                    'Panti Asuhan'
                ],
                datasets: [{
                    label: 'Jumlah AUM',
                    data: [17, 1, 1],
                    backgroundColor: [
                        '#4e73df',
                        '#1cc88a',
                        '#36b9cc',
                        '#f6c23e',
                        '#e74a3b',
                        '#858796',
                        '#2e59d9'
                    ],
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: "Jumlah AUM di PDA Jakarta Timur",
                        font: {
                            size: 16
                        }
                    },
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: context => `Jumlah: ${context.raw}`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
    <script>
        const ctxAumJakbar = document.getElementById('aumJakbarChart').getContext('2d');
        new Chart(ctxAumJakbar, {
            type: 'bar',
            data: {
                labels: [
                    'TK ABA',
                    'Peminjaman Alat Catering',
                    'Pengajian',
                    'Panti Santunan Anak & Lansia'
                ],
                datasets: [{
                    label: 'Jumlah AUM',
                    data: [14, 1, 1, 1],
                    backgroundColor: [
                        '#4e73df',
                        '#1cc88a',
                        '#36b9cc',
                        '#f6c23e',
                        '#e74a3b',
                        '#858796',
                        '#2e59d9'
                    ],
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: "Jumlah AUM di PDA Jakarta Barat",
                        font: {
                            size: 16
                        }
                    },
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: context => `Jumlah: ${context.raw}`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
    <script>
        const ctxAumJakut = document.getElementById('aumJakutChart').getContext('2d');
        new Chart(ctxAumJakut, {
            type: 'bar',
            data: {
                labels: [
                    'TK ABA'
                ],
                datasets: [{
                    label: 'Jumlah AUM',
                    data: [6],
                    backgroundColor: [
                        '#4e73df',
                    ],
                    borderRadius: 6,
                    borderSkipped: false,
                    barPercentage: 0.3, // << ini memperkecil batangnya
                    categoryPercentage: 0.5 // << ini memperkecil area kategori (slot label)
                }]

            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: "Jumlah AUM di PDA Jakarta Utara",
                        font: {
                            size: 16
                        }
                    },
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: context => `Jumlah: ${context.raw}`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#pdaTable').DataTable({
                paging: false,
                info: false,
                responsive: true
            });
        });
    </script>
@endsection
