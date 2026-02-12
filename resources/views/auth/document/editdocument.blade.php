@extends('layouts.master')
@section('title')
    Edit_Document
@endsection

@section('css')
    <link href="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            Document
        @endslot
        @slot('title')
            Edit
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Data</h4>
                    <p class="card-title-desc">Ubah field di bawah ini untuk memperbarui dokumen</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('document.update', $doc->id_doc) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Nama Document</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="name"
                                    value="{{ old('name', $doc->docname) }}" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="form-label col-md-2 col-form-label">Pilih Jenis File</label>
                            <div class="col-md-10">
                                <select class="select2 form-control select2-multiple" name="filetype" id="filetype">
                                    @foreach ($filetype as $value)
                                        <option value="{{ $value->id_filetype }}"
                                            {{ (string) old('filetype', $doc->id_filetype) === (string) $value->id_filetype ? 'selected' : '' }}>
                                            {{ $value->filename }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="form-label col-md-2 col-form-label">File Saat Ini</label>
                            <div class="col-md-10">
                                @if (!empty($doc->uploaded_doc))
                                    <a href="{{ asset('upload/document/' . $doc->uploaded_doc) }}" target="_blank">
                                        {{ $doc->uploaded_doc }}
                                    </a>
                                @else
                                    <span class="text-muted">Belum ada file</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="form-label col-md-2 col-form-label" for="uploaded_doc">
                                Ganti File (Opsional)<br>
                                <i class="text-danger" style="font-size: 10px;">pdf, jpeg, png</i>
                            </label>
                            <div class="col-md-10">
                                <input id="uploaded_doc" name="uploaded_doc" type="file" class="form-control"
                                    accept="image/png, image/jpeg, application/pdf">
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-3">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
                            <a href="{{ route('document.index') }}"
                                class="btn btn-secondary waves-effect waves-light">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
