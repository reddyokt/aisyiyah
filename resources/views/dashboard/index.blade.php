@extends('layouts.master')
@section('title')
    @lang('translation.Dashboard')
@endsection
@section('css')
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .close-icon {
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            {{ Session::get('role_name') }}
        @endslot
        @slot('title')
            Dashboard
        @endslot
    @endcomponent

    <div class="row">
        @include('flashmessage')

        <div class="col-md-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="float-end mt-2">
                        <i class="uil-user   font-size-20"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{ $allData['totalKader'] }}</span></h4>
                        <p class="text-muted mb-0">Total Kader</p>
                    </div>
                </div>
            </div>
        </div> <!-- end col-->

        <div class="col-md-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="float-end mt-2">
                        <i class="uil-store font-size-20"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 mt-1"><span data-plugin="counterup">{{ $allData['totalAum'] }}</span></h4>
                        <p class="text-muted mb-0">Total AUM Aktif</p>
                    </div>
                </div>
            </div>
        </div> <!-- end col-->
    </div> <!-- end row-->

    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Total Program Kerja Periode Aktif</h4>
                    <input type="hidden" class="prokerData" value="{{ $allData['prokerData'] }}" />
                    <div id="pie_chart" data-colors='["--bs-danger", "--bs-danger", "--bs-warning"]' class="apex-charts"
                        dir="ltr"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Program Kerja per PDA</h4>
                    <div id="column_chart" data-colors='["--bs-success", "--bs-danger", "--bs-warning"]' class="apex-charts"
                        dir="ltr"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Kader Aktif per PDA</h4>
                        <div class="mt-3">
                            <input type="hidden" class="totalPDA" value="{{ $allData['totalPDA'] }}" />
                            <input type="hidden" class="pdaList" value="{{ $allData['pdaList'] }}" />
                            <div id="kader_chart" data-colors='["--bs-primary", "#dfe2e6", "--bs-warning"]'
                                class="apex-charts" dir="ltr"></div>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->


            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">AUM aktif per PDA</h4>
                        <div class="mt-3">
                            <input type="hidden" class="totalPDAAum" value="{{ $allData['totalPDAAum'] }}" />
                            <input type="hidden" class="pdaLists" value="{{ $allData['pdaLists'] }}" />
                            <div id="aum_chart" data-colors='["--bs-success", "#dfe2e6", "--bs-warning"]'
                                class="apex-charts" dir="ltr"></div>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end Col -->

    </div> <!-- end row-->

    @if (in_array(Session::get('role_code'), ['MDA1']))
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                            <h5 class="text-danger">Data Program Kerja Menunggu Validasi</h5>
                            <button type="button" class="btn-close close-icon" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                        @include('flashmessage')
                        <div class="table-responsive mb-4">
                            <table id="datatable" class="table table-bordered dt-responsive wrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <th>Nama Program Kerja</th>
                                    <th>Waktu Pelaksanaan</th>
                                    <th>Anggaran</th>
                                    <th>Status</th>
                                    <th>Pengusul</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($datamda as $proker)
                                        <tr>
                                            <td>{{ $proker->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($proker->start)->locale('id')->format('j F Y') }}
                                                ~ {{ \Carbon\Carbon::parse($proker->end)->locale('id')->format('j F Y') }}
                                            </td>
                                            <td>{{ number_format($proker->anggaran, 2, ',', '.') }}</td>
                                            <td>
                                                @if ($proker->status == 'waiting')
                                                    <p>Menunggu</p>
                                                @elseif($proker->status == 'validatedbymda')
                                                    <p>Sudah divalidasi oleh Ketua Majelis</p>
                                                @elseif($proker->status == 'validatedbypda')
                                                    <p>Sudah divalidasi oleh Ketua PDA</p>
                                                @elseif($proker->status == 'validatedbypwa')
                                                    <p>Sudah divalidasi oleh Ketua PWA</p>
                                                @elseif($proker->status == 'rejectbymda')
                                                    <p>Ditolak oleh Ketua Majelis</p>
                                                @elseif($proker->status == 'rejectbypda')
                                                    <p>Ditolak oleh Ketua PDA</p>
                                                @elseif($proker->status == 'rejectbypwa')
                                                    <p>Ditolak oleh Ketua PWA</p>
                                                @elseif($proker->status == 'realized')
                                                    <p>Terealisasi</p>
                                                @elseif($proker->status == 'unrealized')
                                                    <p>Belum terealisasi</p>
                                                @endif
                                            </td>
                                            <td>{{ $proker->username }}</td>
                                            <td id="tooltip-container">
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="/proker/edit/{{ $proker->id_proker }}"
                                                            class="px-2 text-primary" data-bs-container="#tooltip-container"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Edit"><i class="uil uil-pen font-size-18"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="/proker/detail/{{ $proker->id_proker }}"
                                                            class="px-2 text-warning"
                                                            data-bs-container="#tooltip-container"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="detail"><i class="uil uil-eye font-size-18"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="/proker/validasimda/{{ $proker->id_proker }}"
                                                            class="px-2 text-success"
                                                            data-bs-container="#tooltip-container"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="detail"><i
                                                                class="uil uil-check-circle font-size-18"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="/proker/delete/{{ $proker->id_proker }}"
                                                            class="px-2 text-danger"
                                                            data-bs-container="#tooltip-container"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="delete"><i
                                                                class="uil uil-trash-alt font-size-18"></i></a>
                                                    </li>

                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif (in_array(Session::get('role_code'), ['PDA1']))
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                            <h5 class="text-danger">Data Program Kerja Menunggu Validasi</h5>
                            <button type="button" class="btn-close close-icon" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                        @include('flashmessage')
                        <div class="table-responsive mb-4">
                            <table id="datatable-buttons" class="table table-bordered dt-responsive wrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <th>Nama Program Kerja</th>
                                    <th>Jenis</th>
                                    <th>Waktu Pelaksanaan</th>
                                    <th>Anggaran</th>
                                    <th>Status</th>
                                    <th>Pengusul</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($datapda as $proker)
                                        <tr>
                                            <td>{{ $proker->name }}</td>
                                            <td>{{ $proker->typeproker }}</td>
                                            <td>{{ \Carbon\Carbon::parse($proker->start)->locale('id')->format('j F Y') }}
                                                ~ {{ \Carbon\Carbon::parse($proker->end)->locale('id')->format('j F Y') }}
                                            </td>
                                            <td>{{ number_format($proker->anggaran, 2, ',', '.') }}</td>
                                            <td>
                                                @if ($proker->status == 'waiting')
                                                    <p>Menunggu</p>
                                                @elseif($proker->status == 'validatedbymda')
                                                    <p>Sudah divalidasi oleh Ketua Majelis</p>
                                                @elseif($proker->status == 'validatedbypda')
                                                    <p>Sudah divalidasi oleh Ketua PDA</p>
                                                @elseif($proker->status == 'validatedbypwa')
                                                    <p>Sudah divalidasi oleh Ketua PWA</p>
                                                @elseif($proker->status == 'rejectbymda')
                                                    <p>Ditolak oleh Ketua Majelis</p>
                                                @elseif($proker->status == 'rejectbypda')
                                                    <p>Ditolak oleh Ketua PDA</p>
                                                @elseif($proker->status == 'rejectbypwa')
                                                    <p>Ditolak oleh Ketua PWA</p>
                                                @elseif($proker->status == 'realized')
                                                    <p>Terealisasi</p>
                                                @elseif($proker->status == 'unrealized')
                                                    <p>Belum terealisasi</p>
                                                @endif
                                            </td>
                                            <td>{{ $proker->username }}</td>
                                            <td id="tooltip-container">
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="/proker/edit/{{ $proker->id_proker }}"
                                                            class="px-2 text-primary"
                                                            data-bs-container="#tooltip-container"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Edit"><i class="uil uil-pen font-size-18"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="/proker/detail/{{ $proker->id_proker }}"
                                                            class="px-2 text-warning"
                                                            data-bs-container="#tooltip-container"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="detail"><i class="uil uil-eye font-size-18"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="/proker/validasipda/{{ $proker->id_proker }}"
                                                            class="px-2 text-success"
                                                            data-bs-container="#tooltip-container"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="detail"><i
                                                                class="uil uil-check-circle font-size-18"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="/proker/delete/{{ $proker->id_proker }}"
                                                            class="px-2 text-danger"
                                                            data-bs-container="#tooltip-container"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="delete"><i
                                                                class="uil uil-trash-alt font-size-18"></i></a>
                                                    </li>

                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif (in_array(Session::get('role_code'), ['SUP' || 'PWA1']))
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                            <h5 class="text-danger">Data Program Kerja Menunggu Validasi</h5>
                            <button type="button" class="btn-close close-icon" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                        @include('flashmessage')
                        <div class="table-responsive mb-4">
                            <table id="datatable-buttons" class="table table-bordered dt-responsive wrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <th>Nama Program Kerja</th>
                                    <th>Jenis</th>
                                    <th>Waktu Pelaksanaan</th>
                                    <th>Anggaran</th>
                                    <th>Status</th>
                                    <th>Pengusul</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($datapwa as $proker)
                                        <tr>
                                            <td>{{ $proker->name }}</td>
                                            <td>{{ $proker->typeproker }}</td>
                                            <td>{{ \Carbon\Carbon::parse($proker->start)->locale('id')->format('j F Y') }}
                                                ~ {{ \Carbon\Carbon::parse($proker->end)->locale('id')->format('j F Y') }}
                                            </td>
                                            <td>{{ number_format($proker->anggaran, 2, ',', '.') }}</td>
                                            <td>
                                                @if ($proker->status == 'waiting')
                                                    <p>Menunggu</p>
                                                @elseif($proker->status == 'validatedbymda')
                                                    <p>Sudah divalidasi oleh Ketua Majelis</p>
                                                @elseif($proker->status == 'validatedbypda')
                                                    <p>Sudah divalidasi oleh Ketua PDA</p>
                                                @elseif($proker->status == 'validatedbypwa')
                                                    <p>Sudah divalidasi oleh Ketua PWA</p>
                                                @elseif($proker->status == 'rejectbymda')
                                                    <p>Ditolak oleh Ketua Majelis</p>
                                                @elseif($proker->status == 'rejectbypda')
                                                    <p>Ditolak oleh Ketua PDA</p>
                                                @elseif($proker->status == 'rejectbypwa')
                                                    <p>Ditolak oleh Ketua PWA</p>
                                                @elseif($proker->status == 'realized')
                                                    <p>Terealisasi</p>
                                                @elseif($proker->status == 'unrealized')
                                                    <p>Belum terealisasi</p>
                                                @endif
                                            </td>
                                            <td>{{ $proker->username }}</td>
                                            <td id="tooltip-container">
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="/proker/edit/{{ $proker->id_proker }}"
                                                            class="px-2 text-primary"
                                                            data-bs-container="#tooltip-container"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Edit"><i class="uil uil-pen font-size-18"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="/proker/detail/{{ $proker->id_proker }}"
                                                            class="px-2 text-warning"
                                                            data-bs-container="#tooltip-container"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="detail"><i class="uil uil-eye font-size-18"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="/proker/validasipwa/{{ $proker->id_proker }}"
                                                            class="px-2 text-success"
                                                            data-bs-container="#tooltip-container"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="detail"><i
                                                                class="uil uil-check-circle font-size-18"></i></a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="/proker/delete/{{ $proker->id_proker }}"
                                                            class="px-2 text-danger"
                                                            data-bs-container="#tooltip-container"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="delete"><i
                                                                class="uil uil-trash-alt font-size-18"></i></a>
                                                    </li>

                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    <script>
        $('#newpass, #confnewpass').on('keyup', function() {
            if ($('#newpass').val() == $('#confnewpass').val()) {
                $('#message').html('Password Konfirmasi Cocok').css('color', 'green');
            } else
                $('#message').html('Password Konfirmasi Tidak Cocok').css('color', 'red');
        });
    </script>
    <script>
        $('.close-icon').on('click', function() {
            $(this).closest('.card').fadeOut();
        })
    </script>
    <script>
        var labelPdaList = "{{__('Kader Aktif ')}}"
        var labelPdaLists = "{{__('AUM Aktif ')}}"
        var labelTerealisasi = "{{__('Terealisasi ')}}"
        var labelTidak = "{{__('Tidak Terealisasi ')}}"
        var labelProgress = "{{__('On Progress ')}}"
    </script>
    <script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>
@endsection
