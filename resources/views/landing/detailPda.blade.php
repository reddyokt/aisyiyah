@extends('layouts-landing.master')

@section('title', "Data Pimpinan Cabang 'Aisyiyah")

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container mt-4 mb-10">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white mb-5">
                <h5 class="mb-0">Detail Data PDA {{ $pda->pda_name }}</h5>
            </div>
            <div class="card-body p-0">
                <div class="pca-table p-5">
                    <h4 class="card-title">Data PCA</h4>
                    <table id="datatable" class="table table-bordered dt-responsive wrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama PCA</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pca as $c)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ strtoupper($c->pca_name) }}</td>
                                    <td>{{ $c->address ?? 'Alamat belum diisi' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pca-table p-5">
                    <h4 class="card-title">Data Ranting</h4>
                    <table id="datatablepra" class="table table-bordered dt-responsive wrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Ranting</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pra as $r)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ strtoupper($r->ranting_name) }}</td>
                                    <td>{{ $r->address ?? 'Alamat belum diisi' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pca-table p-5">
                    <h4 class="card-title">Data AUM</h4>
                    <table id="datatableaum" class="table table-bordered dt-responsive wrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama AUM</th>
                                <th>Status Kepemilikan</th>
                                <th>Bidang Usaha</th>
                                <th>Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aum as $auc)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ strtoupper($auc->aum_name) }}</td>
                                    <td>{{ $auc->kepemilikan_name ?? 'Tidak ada data' }}</td>
                                    <td>{{ $auc->bidangusaha_name ?? 'Tidak ada data' }}</td>
                                    <td>{{ $auc->address ?? 'Alamat belum diisi' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('page-script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                responsive: true,
                lengthMenu: [5, 10, 25, 50],
                pageLength: 5,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data"
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#datatableaum').DataTable({
                responsive: true,
                lengthMenu: [5, 10, 25, 50],
                pageLength: 5,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data"
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#datatablepra').DataTable({
                responsive: true,
                lengthMenu: [5, 10, 25, 50],
                pageLength: 5,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data"
                }
            });
        });
    </script>
@endsection
