@extends('layouts.master')
@section('title')
    @lang('translation.Basic_Elements')
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            AUM
        @endslot
        @slot('title')
            Add New
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Isi Data</h4>
                    <p class="card-title-desc">Lengkapi field dibawah ini untuk membuat data AUM</p>
                    <form action="/aum/create" method="POST" id="createnewaum" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ Auth::id() }}" name="id">
                        <div class="mb-3 row">
                            <div class="col-lg-6">
                                <label class="form-label col-form-label">Pengelolaan oleh</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="pengelola1"
                                        value="1">
                                    <label class="form-check-label" for="inlineRadio1">Ranting</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="pengelola2"
                                        value="2">
                                    <label class="form-check-label" for="inlineRadio2">PCA</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="pengelola3"
                                        value="3">
                                    <label class="form-check-label" for="inlineRadio3">PDA</label>
                                </div>
                            </div>
                            <div class="col-lg-6" id="divrantings" style="display: none;">
                                <label class="form-label col-form-label">Pilih Ranting</label>
                                <div class="col-lg-12">
                                    <select class="select2 form-control select2-multiple" name="ranting" id="rantings"
                                        data-placeholder="{{ __('account.placeholder_rantings') }}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6" id="divpcas" style="display: none;">
                                <label class="form-label col-form-label">Pilih PCA</label>
                                <div class="col-lg-12">
                                    <select class="select2 form-control select2-multiple" name="pca" id="pcas"
                                        data-placeholder="{{ __('account.placeholder_pcas') }}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6" id="divpdas" style="display: none">
                                <label class="form-label col-form-label">Pilih PDA</label>
                                <div class="col-lg-12">
                                    <select class="select2 form-control select2-multiple" name="pda" id="pdas"
                                        data-placeholder="{{ __('account.placeholder_pdas') }}">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-lg-4">
                                <label for="code" class="form-label col-form-label">Nama AUM</label>
                                <div class="col-lg-12">
                                    <input class="form-control" type="text" id="name" name="name"
                                        placeholder="masukkan name aum" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label col-form-label">Pilih Bidang Usaha</label>
                                <div class="col-lg-12">
                                    <select class="select2 form-control select2-multiple" name="bidangusaha"
                                        id="bidangusaha">
                                        <option selected disabled>Pilih Bidang Usaha</option>
                                        @foreach ($bidangusaha as $key => $value)
                                            <option value="{{ $value->id_bidangusaha }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label col-form-label">Pilih Kepemilikan</label>
                                <div class="col-lg-12">
                                    <select class="select2 form-control select2-multiple" name="kepemilikan"
                                        id="kepemilikan">
                                        <option selected disabled>Pilih Kepemilikan</option>
                                        @foreach ($kepemilikan as $key => $value)
                                            <option value="{{ $value->id_kepemilikan }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="address">Alamat</label>
                                    <textarea class="form-control" type="text" name="address" id="address"></textarea>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="mb-3 row">
                            <div class="col-lg-6">
                                <label class="form-label col-form-label">Pilih Pengelolaan Oleh</label>
                                <div class="col-lg-12">
                                    <select class="select2 form-control select2-multiple" 
                                        id="pengelola">
                                        <option selected disabled>Pilih Pengelola</option>
                                        <option value="1">Ranting</option>
                                        <option value="2">PCA</option>
                                        <option value="3">PDA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6" id="divrantings" style="display: none;">
                                <label class="form-label col-form-label">Pilih Ranting</label>
                                <div class="col-lg-12">
                                    <select class="select2 form-control select2-multiple" 
                                        name="ranting" id="rantings" data-placeholder="{{ __('account.placeholder_rantings') }}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6" id="divpcas" style="display: none;">
                                    <label class="form-label col-form-label">Pilih PCA</label>
                                <div class="col-lg-12">
                                    <select class="select2 form-control select2-multiple" 
                                        name="pca" id="pcas" data-placeholder="{{ __('account.placeholder_pcas') }}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6" id="divpdas" style="display: none">
                                    <label class="form-label col-form-label">Pilih PDA</label>
                                <div class="col-lg-12">
                                    <select class="select2 form-control select2-multiple" 
                                        name="pda" id="pdas" data-placeholder="{{ __('account.placeholder_pdas') }}">
                                    </select>
                                </div>
                            </div>
                        </div> --}}
                        <div class="d-flex flex-wrap gap-3">
                            {{-- <button type="submit" class="btn btn-primary waves-effect waves-light w-md">Submit</button> --}}
                            <button type="submit" class="btn btn-primary waves-effect waves-light"
                                id="sa-add-success">Simpan </button>

                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection
@section('script')
    <script src="{{ asset('assets/js/account.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/ecommerce-add-product.init.js') }}"></script>  
@endsection
