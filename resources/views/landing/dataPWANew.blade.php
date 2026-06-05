@extends('layouts-landing.master')

@section('title', "Data Pimpinan Wilayah 'Aisyiyah DKI Jakarta")

@section('content')
    <!-- Page Header -->
    <section class="wrapper image-wrapper bg-image bg-overlay bg-overlay-300 text-white"
        data-image-src="{{ URL::asset('landing/assets/img/photos/Sejarah-Aisyiyah.jpg') }}">
        <div class="container pt-18 pb-16">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-3 text-white mb-3">Data PWA DKI Jakarta</h1>
                    <p class="lead fs-lg text-white mb-0">Visualisasi sebaran Pimpinan Cabang 'Aisyiyah se-DKI Jakarta</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Cards -->
    <section class="wrapper bg-light">
        <div class="container pt-12 pb-6">
            <div class="row gx-md-6 gy-4 text-center">
                <div class="col-md-4" data-cues="zoomIn" data-delay="200">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="icon btn btn-circle btn-soft-primary pe-none mx-auto mb-3">
                                <i class="uil uil-building fs-24"></i>
                            </div>
                            <h3 class="counter-lg text-primary mb-1">{{ $data->count() }}</h3>
                            <p class="text-muted mb-0">PDA</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-cues="zoomIn" data-delay="400">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="icon btn btn-circle btn-soft-violet pe-none mx-auto mb-3">
                                <i class="uil uil-location-point fs-24"></i>
                            </div>
                            <h3 class="counter-lg text-violet mb-1">{{ $data->sum('total_pca') }}</h3>
                            <p class="text-muted mb-0">Total Cabang (PCA)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-cues="zoomIn" data-delay="600">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="icon btn btn-circle btn-soft-orange pe-none mx-auto mb-3">
                                <i class="uil uil-analysis fs-24"></i>
                            </div>
                            <h3 class="counter-lg text-orange mb-1">{{ number_format($data->avg('total_pca'), 1) }}</h3>
                            <p class="text-muted mb-0">Rata-rata PCA per PDA</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Chart Section -->
    <section class="wrapper bg-white">
        <div class="container pb-14 pb-md-16">
            <div class="row text-center mb-8">
                <div class="col-lg-8 mx-auto">
                    <h2 class="fs-16 text-uppercase text-primary mb-3">Grafik</h2>
                    <h3 class="display-4 mb-4">Sebaran PCA per PDA</h3>
                    <p class="lead fs-lg text-muted">Klik pada grafik untuk melihat detail masing-masing PDA.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-body p-4 p-md-6">
                            <canvas id="chartPDA" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PDA List -->
            <div class="row mt-10">
            <div class="col-lg-10 mx-auto">
                    <h4 class="mb-4"><i class="uil uil-list-ul me-2 text-primary"></i>Daftar PDA</h4>
                    <div class="row g-4">
                        @foreach ($data as $item)
                            <div class="col-md-6" data-cues="fadeIn" data-delay="{{ ($loop->index % 2) * 150 }}">
                                <a href="{{ url('dataPWA/detail/pda/' . $item->pda_id) }}" class="text-decoration-none">
                                    <div class="card shadow-sm lift border-0 rounded-3 h-100">
                                        <div class="card-body p-4 d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5 class="mb-1 text-dark">{{ $item->pda_name }}</h5>
                                                <span class="badge bg-soft-primary text-primary rounded-pill">
                                                    <i class="uil uil-building me-1"></i>{{ $item->total_pca }} PCA
                                                </span>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <span class="icon btn btn-circle btn-soft-primary pe-none">
                                                    <i class="uil uil-arrow-right fs-18"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('chartPDA').getContext('2d');

            const labels = {!! json_encode($data->pluck('pda_name')) !!};
            const values = {!! json_encode($data->pluck('total_pca')) !!};
            const pdaIds = {!! json_encode($data->pluck('pda_id')) !!};

            const gradientColors = [
                'rgba(79, 70, 229, 0.85)',
                'rgba(139, 92, 246, 0.85)',
                'rgba(6, 182, 212, 0.85)',
                'rgba(16, 185, 129, 0.85)',
                'rgba(245, 158, 11, 0.85)',
                'rgba(239, 68, 68, 0.85)',
                'rgba(59, 130, 246, 0.85)',
                'rgba(168, 85, 247, 0.85)',
                'rgba(236, 72, 153, 0.85)',
                'rgba(20, 184, 166, 0.85)',
            ];

            const borderColors = gradientColors.map(c => c.replace('0.85', '1'));

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah PCA',
                        data: values,
                        backgroundColor: labels.map((_, i) => gradientColors[i % gradientColors
                            .length]),
                        borderColor: labels.map((_, i) => borderColors[i % borderColors.length]),
                        borderWidth: 1,
                        borderRadius: 6,
                        borderSkipped: false,
                        barPercentage: 0.75,
                        categoryPercentage: 0.85,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1200,
                        easing: 'easeOutQuart',
                    },
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            padding: 12,
                            cornerRadius: 8,
                            titleFont: {
                                size: 14,
                                weight: 'bold',
                            },
                            bodyFont: {
                                size: 13,
                            },
                            callbacks: {
                                label: function(ctx) {
                                    return `Jumlah PCA: ${ctx.raw}`;
                                }
                            }
                        },
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false,
                            },
                            ticks: {
                                maxRotation: 45,
                                font: {
                                    size: 11,
                                },
                            },
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                font: {
                                    size: 12,
                                },
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.06)',
                            },
                        },
                    },
                    onClick: (evt, activeEls) => {
                        if (activeEls.length > 0) {
                            const index = activeEls[0].index;
                            const pdaId = pdaIds[index];
                            window.location.href = `dataPWA/detail/pda/${pdaId}`;
                        }
                    },
                },
            });
        });
    </script>
@endsection

@push('head')
<style>
    .counter-lg {
        font-size: 2.2rem;
        font-weight: 700;
    }
    .card.lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card.lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
    }
</style>
@endpush