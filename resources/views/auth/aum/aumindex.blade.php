@extends('layouts.master')
@section('title')
    AUM
@endsection

@section('css')
    {{-- DataTables Bootstrap 5 (format baku project) --}}
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            AUM
        @endslot
        @slot('title')
            AUM List
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
                                <a href="{{ url('/aum/create') }}" class="btn btn-success waves-effect waves-light">
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
                                    <th scope="col">Nama AUM</th>
                                    <th scope="col">Bidang Usaha</th>
                                    <th scope="col">Pengelolaan</th>
                                    <th scope="col">Kepemilikan</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" style="width: 200px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aumindex as $aum)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="width: 30%;">{{ $aum->aum_name }}</td>
                                        <td>{{ $aum->bidangusaha }}</td>

                                        <td>
                                            @if (!is_null($aum->ranting_id))
                                                Ranting {{ $aum->ranting_name }}
                                            @elseif (!is_null($aum->pca_id))
                                                PCA {{ $aum->pca_name }}
                                            @else
                                                PDA {{ $aum->pda_name }}
                                            @endif
                                        </td>

                                        <td>{{ $aum->kepemilikan_name }}</td>

                                        <td>
                                            @if ($aum->status === 'Yes')
                                                <div class="badge bg-pill bg-soft-success font-size-12">Active</div>
                                            @else
                                                <div class="badge bg-pill bg-soft-danger font-size-12">Not Active</div>
                                            @endif
                                        </td>

                                        <td style="width: 15%">
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <a href="{{ url('aum/detail/' . Crypt::encrypt($aum->id_aum)) }}"
                                                        class="px-2 text-warning">
                                                        <i class="uil uil-eye font-size-14"></i>
                                                    </a>
                                                </li>

                                                <li class="list-inline-item">
                                                    <a href="{{ route('aum.edit', Crypt::encrypt($aum->id_aum)) }}"
                                                        class="px-2 text-primary">
                                                        <i class="uil uil-pen font-size-14"></i>
                                                    </a>
                                                </li>

                                                {{-- OPTION A (recommended): form DELETE --}}
                                                {{--
                                                <li class="list-inline-item">
                                                    <form action="{{ route('aum.destroy', Crypt::encrypt($aum->id_aum)) }}" method="POST"
                                                        onsubmit="return confirm('Hapus data AUM ini?')" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link px-2 text-danger p-0">
                                                            <i class="uil uil-trash-alt font-size-14"></i>
                                                        </button>
                                                    </form>
                                                </li>
                                                --}}

                                                {{-- OPTION B (legacy, sesuai existing kamu): GET delete --}}
                                                <li class="list-inline-item">
                                                    <a href="{{ url('aum/delete/' . Crypt::encrypt($aum->id_aum)) }}"
                                                        class="px-2 text-danger"
                                                        onclick="return confirm('Hapus data AUM ini?')">
                                                        <i class="uil uil-trash-alt font-size-14"></i>
                                                    </a>
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
            $('#datatable').DataTable({
                pageLength: 10,
                order: [
                    [0, 'asc']
                ]
            });
        });
    </script>
@endsection
