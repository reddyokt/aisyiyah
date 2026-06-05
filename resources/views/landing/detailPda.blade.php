@extends('layouts-landing.master')

@section('title', "Detail Data PDA " . $pda->pda_name)

@section('content')
    <!-- Page Header -->
    <section class="wrapper image-wrapper bg-image bg-overlay bg-overlay-300 text-white"
        data-image-src="{{ URL::asset('landing/assets/img/photos/Sejarah-Aisyiyah.jpg') }}">
        <div class="container pt-16 pb-14">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-3 text-white mb-2">{{ $pda->pda_name }}</h1>
                    <p class="lead fs-lg text-white mb-0">
                        <i class="uil uil-map-marker me-1"></i>PDA 'Aisyiyah
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Summary Cards -->
    <section class="wrapper bg-light">
        <div class="container pt-10 pb-4">
            <div class="row gx-md-6 gy-4 text-center">
                <div class="col-md-4" data-cues="zoomIn" data-delay="200">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="icon btn btn-circle btn-soft-primary pe-none mx-auto mb-3">
                                <i class="uil uil-building fs-24"></i>
                            </div>
                            <h3 class="counter-lg text-primary mb-1">{{ $pca->count() }}</h3>
                            <p class="text-muted mb-0">Pimpinan Cabang (PCA)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-cues="zoomIn" data-delay="400">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="icon btn btn-circle btn-soft-violet pe-none mx-auto mb-3">
                                <i class="uil uil-house-user fs-24"></i>
                            </div>
                            <h3 class="counter-lg text-violet mb-1">{{ $pra->count() }}</h3>
                            <p class="text-muted mb-0">Ranting (PRA)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-cues="zoomIn" data-delay="600">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="icon btn btn-circle btn-soft-orange pe-none mx-auto mb-3">
                                <i class="uil uil-bag-alt fs-24"></i>
                            </div>
                            <h3 class="counter-lg text-orange mb-1">{{ $aum->count() }}</h3>
                            <p class="text-muted mb-0">Amal Usaha (AUM)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Detail Tables -->
    <section class="wrapper bg-white">
        <div class="container py-10 py-md-12">
            <div class="row g-8">
                <!-- PCA Table -->
                <div class="col-12" data-cues="fadeIn" data-delay="200">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                            <h4 class="mb-0">
                                <span class="icon btn btn-circle btn-soft-primary btn-sm pe-none me-2">
                                    <i class="uil uil-building"></i>
                                </span>
                                Data Pimpinan Cabang (PCA)
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" style="width: 50px;">#</th>
                                            <th scope="col">Nama PCA</th>
                                            <th scope="col">Alamat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pca as $c)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="fw-semibold">{{ strtoupper($c->pca_name) }}</td>
                                                <td class="text-muted">{{ $c->address ?? 'Alamat belum diisi' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted py-4">Belum ada data PCA</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PRA Table -->
                <div class="col-12" data-cues="fadeIn" data-delay="400">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                            <h4 class="mb-0">
                                <span class="icon btn btn-circle btn-soft-violet btn-sm pe-none me-2">
                                    <i class="uil uil-house-user"></i>
                                </span>
                                Data Ranting (PRA)
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" style="width: 50px;">#</th>
                                            <th scope="col">Nama Ranting</th>
                                            <th scope="col">Alamat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pra as $r)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="fw-semibold">{{ strtoupper($r->ranting_name) }}</td>
                                                <td class="text-muted">{{ $r->address ?? 'Alamat belum diisi' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted py-4">Belum ada data Ranting</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- AUM Table -->
                <div class="col-12" data-cues="fadeIn" data-delay="600">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                            <h4 class="mb-0">
                                <span class="icon btn btn-circle btn-soft-orange btn-sm pe-none me-2">
                                    <i class="uil uil-bag-alt"></i>
                                </span>
                                Data Amal Usaha (AUM)
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" style="width: 50px;">#</th>
                                            <th scope="col">Nama AUM</th>
                                            <th scope="col">Kepemilikan</th>
                                            <th scope="col">Bidang Usaha</th>
                                            <th scope="col">Alamat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($aum as $auc)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="fw-semibold">{{ strtoupper($auc->aum_name) }}</td>
                                                <td>{{ $auc->kepemilikan_name ?? '-' }}</td>
                                                <td><span class="badge bg-soft-primary text-primary rounded-pill">{{ $auc->bidangusaha_name ?? '-' }}</span></td>
                                                <td class="text-muted">{{ $auc->address ?? 'Alamat belum diisi' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">Belum ada data AUM</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('head')
<style>
    .counter-lg {
        font-size: 2.2rem;
        font-weight: 700;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(79, 70, 229, 0.04);
    }
</style>
@endpush