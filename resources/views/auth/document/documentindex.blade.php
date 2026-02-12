@extends('layouts.master')
@section('title')
    Document
@endsection

@section('css')
    <!-- DataTables (sesuai format baku project) -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            Document
        @endslot
        @slot('title')
            Document List
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @include('flashmessage')

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <a href="{{ route('document.create') }}" class="btn btn-success waves-effect waves-light">
                                    <i class="mdi mdi-plus me-2"></i> Add New
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table id="datatable" class="table table-centered dt-responsive-wrap mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Document</th>
                                    <th scope="col">Jenis Document</th>
                                    <th scope="col">Uploader</th>
                                    <th scope="col" style="width: 200px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documentindex as $doc)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td style="width: 30%">
                                            {{ $doc->docname }}
                                            @if (!empty($doc->uploaded_doc))
                                                <span class="icon icon-lg">
                                                    <a href="{{ asset('upload/document/' . $doc->uploaded_doc) }}"
                                                        target="_blank">
                                                        <i class="uil-file-download-alt"></i>
                                                    </a>
                                                </span>
                                            @endif
                                        </td>

                                        <td style="width: 30%">{{ $doc->filename }}</td>

                                        <td>
                                            @if (empty($doc->pda_id))
                                                {{ $doc->name }}
                                            @else
                                                {{ $doc->name }} - {{ $doc->pda_name }}
                                            @endif
                                        </td>

                                        <td>
                                            <ul class="list-inline mb-0">

                                                {{-- Kalau belum ada fitur edit dokumen, mending hidden dulu --}}
                                                <li class="list-inline-item">
                                                    <a href="{{ route('document.edit', $doc->id_doc) }}"
                                                        class="px-2 text-primary">
                                                        <i class="uil uil-pen font-size-18"></i>
                                                    </a>
                                                </li>

                                                <li class="list-inline-item">
                                                    <form action="{{ route('document.destroy', $doc->id_doc) }}"
                                                        method="POST" onsubmit="return confirm('Hapus dokumen ini?')"
                                                        style="display:inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link px-2 text-danger p-0">
                                                            <i class="uil uil-trash-alt font-size-18"></i>
                                                        </button>
                                                    </form>
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
@endsection

@section('script')
    {{-- Format baku DataTables project kamu --}}
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>

    <script>
        $(function() {
            $('#datatable').DataTable();
        });
    </script>
@endsection
