@extends('layouts.master')
@section('title')
    Create_Proker
@endsection
@section('css')
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            Program Kerja
        @endslot
        @slot('title')
            Edit
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div id="addproduct-accordion" class="custom-accordion">
                @include('flashmessage')
                <div class="card">
                    <form action="/proker/edit/{{ $editproker->id_proker }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ Auth::id() }}" name="id">

                        @if ($role == "SUP" || $role == "PWA1" || $role == "PWA2")
                        @else
                            <input type="hidden" value="{{ Session::get('pda_id') }}" name="pda_id">
                        @endif

                        {{-- <input type="hidden" value="{{$periode->id_periode}}" name="periode"> --}}
                        <input type="hidden" value="Start" name="initial">
                        <a href="#addproduct-billinginfo-collapse" class="text-dark" data-bs-toggle="collapse"
                            aria-expanded="true" aria-controls="addproduct-billinginfo-collapse">
                            <div class="p-4">

                                <div class="d-flex align-items-center mb-1">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-xs">
                                            <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                01
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h5 class="font-size-16 mb-1">Program Kerja Information</h5>
                                        <p class="text-muted text-truncate mb-0">Fill all information below</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div id="addrproker-billinginfo-collapse" class="collapse show"
                            data-bs-parent="#addproker-accordion">
                            <div class="p-4 border-top">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="prokername">Nama Proker</label>
                                            <input id="prokername" name="prokername" type="text" class="form-control"
                                                placeholder="Enter your Program Kerja" value="{{ $editproker->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label" for="from">Mulai
                                                    Program Kerja</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="from" name="from"
                                                        placeholder="pilih Tanggal mulai"
                                                        value="{{ $editproker->start }}" minDate="{{ $editproker->start }}">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label" for="to">Selesai
                                                    Program Kerja</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="to" name="to"
                                                        placeholder="pilih Tanggal selesai"
                                                        value="{{ $editproker->end }}" maxDate="{{ $editproker->end }}">
                                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="anggaran">Masukkan Jumlah Anggaran</label>
                                            <div class="input-group">
                                                <div class="input-group-text">Rp.</div>
                                                <input type="text" class="form-control nums" value="{{ $editproker->anggaran }}"
                                                    id="specificSizeInputGroupUsername" placeholder="Anggaran dalam rupiah" name="anggaran">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- @if ($role == "SUP" || $role == "PWA1" || $role == "PWA2")
                                    <div class="col-lg-6">
                                        <div class="col-md-12">
                                            <label class="form-label" for="anggaran">Pilih PDA</label>
                                            <select class="form-control" name="pda_id" id="pda_id" data-placeholder="PDA ...">
                                                <option selected disabled>Pilih PDA</option>
                                                @foreach ($pda as $key => $value)
                                                    <option value="{{ $value->pda_id }}">{{ $value->pda_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @else
                                    @endif --}}
                                </div>
                                <div class="row">
                                    <label class="form-label" for="username">Masukkan Deskripsi/RAB/Lain-lain</label>
                                    <div class="col-md-12">
                                        <textarea class="col-md-12 form-control" id="body" name="description">{{ $editproker->descr }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 border-top">
                            <div class="d-flex flex-wrap">
                                <button type="submit" class="btn btn-primary waves-effect waves-light"
                                    id="sa-add-success">Simpan</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/js/account.js') }}"></script>
    {{-- <script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script> --}}
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#from").datepicker({
                format: 'dddd MMMM yyyy',
                numberOfMonths: 1,
                onSelect: function(selected) {
                    var dt = new Date(selected);
                    dt.setDate(dt.getDate());
                    $("#to").datepicker("option", "minDate", dt);
                }
            });
            $("#to").datepicker({
                format: 'dddd MMMM yyyy',
                numberOfMonths: 1,
                onSelect: function(selected) {
                    var dt = new Date(selected);
                    dt.setDate(dt.getDate());
                    $("#from").datepicker("option", "maxDate", dt);
                }
            });
        });
    </script>
    <script src="{{ URL::asset('/assets/libs/ckeditor/ckeditor.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/form-editor.init.js') }}"></script>
    <script>
        ClassicEditor.defaultConfig = {
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    '|',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'insertTable',
                    '|'
                ]
            },
            table: {
                contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
            },
            language: 'en'
        };

        ClassicEditor
            .create(document.querySelector('#body'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
