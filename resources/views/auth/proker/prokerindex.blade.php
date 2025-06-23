@extends('layouts.master')
@section('title')
    Program Kerja
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            Program Kerja
        @endslot
        @slot('title')
            List Program Kerja
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('flashmessage')
                <div class="card-body">
                    <a href="/proker/create" type="button" class="btn btn-success waves-effect waves-light mb-3">
                        Create New </a>
                    <table id="datatable-buttons" class="table table-bordered dt-responsive wrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Nama Program Kerja</th>
                                <th>Waktu Pelaksanaan</th>
                                <th>Anggaran</th>
                                <th>Status</th>
                                <th>Pengusul</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prokerindex as $proker)
                                <tr>
                                    <td>{{ $proker->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($proker->start)->locale('id')->format('j F Y') }} ~
                                        {{ \Carbon\Carbon::parse($proker->end)->locale('id')->format('j F Y') }}</td>
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
                                            @if ($proker->status != 'validatedbypwa')
                                                <li class="list-inline-item">
                                                    <a href="/proker/edit/{{ $proker->id_proker }}"
                                                        class="px-1 text-primary" data-bs-container="#tooltip-container"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i
                                                            class="uil uil-pen font-size-14"></i></a>
                                                </li>
                                            @else
                                            @endif

                                            @if ($proker->status == 'validatedbypwa' or $proker->status == 'realized')
                                                <li class="list-inline-item">
                                                    <a href="/proker/update/{{ $proker->id_proker }}"
                                                        class="px-1 text-primary" data-bs-container="#tooltip-container"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Update"><i
                                                            class="uil uil-clipboard-notes font-size-14"></i></a>
                                                </li>
                                            @else
                                            @endif

                                            @if ($proker->status == 'validatedbypwa' or $proker->status == 'realized')
                                            @else
                                                <li class="list-inline-item">
                                                    <a href="/proker/delete/{{ $proker->id_proker }}"
                                                        class="px-1 text-danger" data-bs-container="#tooltip-container"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i
                                                            class="uil uil-trash-alt font-size-14"></i></a>
                                                </li>
                                            @endif
                                            <li class="list-inline-item">
                                                <a href="/proker/detail/{{ $proker->id_proker }}" class="px-1 text-warning"
                                                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Detail"><i
                                                        class="uil uil-eye font-size-14"></i></a>
                                            </li>

                                            @if ($proker->status == 'validatedbypwa')
                                                <li class="list-inline-item">
                                                    <a href="/proker/realized/{{ $proker->id_proker }}"
                                                        class="px-1 text-success" data-bs-container="#tooltip-container"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Terealisasi"><i class="bx bx-trophy font-size-14"></i></a>
                                                </li>
                                            @else
                                            @endif

                                            @if ($proker->status == 'validatedbypwa')
                                                <li class="list-inline-item">
                                                    <a href="/proker/unrealized/{{ $proker->id_proker }}"
                                                        class="px-1 text-danger" data-bs-container="#tooltip-container"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Tidak Terealisasi"><i
                                                            class="bx bx-x-circle font-size-14"></i></a>
                                                </li>
                                            @else
                                            @endif
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
@endsection
