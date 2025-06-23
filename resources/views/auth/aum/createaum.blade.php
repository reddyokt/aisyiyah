@extends('layouts.master')
@section('title')
    Create_AUM
@endsection
@section('css')
    <style>
        .container {
            max-width: 500px;
        }
        dl, ol, ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .imgPreview img {
            padding: 8px;
            max-width: 200px;
        }
    </style>
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
                    <form action="/aum/create" method="POST" name="createnewaum" id="createnewaum"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3 row">
                            <input type="hidden" value="{{ Auth::id() }}" name="id">
                            {{-- <input type="hidden" class="aum_id" name="aum_id" id="aum_id" value=""> --}}
                            <div class="col-lg-6">
                                <label class="form-label col-form-label">Pengelolaan oleh</label>
                                <div class="form-check form-check-inline">
                                    <input required class="form-group form-check-input" type="radio" name="inlineRadioOptions"
                                        id="pengelola1" value="Ranting">
                                    <label class="form-check-label" for="inlineRadio1">Ranting</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-group form-check-input" type="radio" name="inlineRadioOptions"
                                        id="pengelola2" value="PCA">
                                    <label class="form-check-label" for="inlineRadio2">PCA</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-group form-check-input" type="radio" name="inlineRadioOptions"
                                        id="pengelola3" value="PDA">
                                    <label class="form-check-label" for="inlineRadio3">PDA</label>
                                </div>
                            </div>
                            <div class="col-lg-12" id="divrantings" style="display: none;">
                                <label class="form-label col-form-label">Pilih Ranting</label>
                                <div class="col-lg-12">
                                    <select class="form-group select2 form-control select2-multiple" name="ranting_id"
                                        id="rantings" data-placeholder="{{ __('account.placeholder_rantings') }}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12" id="divpcas" style="display: none;">
                                <label class="form-label col-form-label">Pilih PCA</label>
                                <div class="col-lg-12">
                                    <select class="form-group select2 form-control select2-multiple" name="pca"
                                        id="pcas" data-placeholder="{{ __('account.placeholder_pcas') }}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6" id="divpcass" style="display: none;">
                                <label class="form-label col-form-label">PCA</label>
                                <div class="col-lg-12">
                                    <select class="form-group select2 form-control select2-multiple" name="pca"
                                        id="pcass" data-placeholder="{{ __('account.placeholder_pcass') }}" disabled>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12" id="divpdas" style="display: none">
                                <label class="form-label col-form-label">Pilih PDA</label>
                                <div class="col-lg-12">
                                    <select class="form-group select2 form-control select2-multiple" name="pda"
                                        id="pdas" data-placeholder="{{ __('account.placeholder_pdas') }}">
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6" id="divpdass" style="display: none">
                                <label class="form-label col-form-label">PDA</label>
                                <div class="col-lg-12">
                                    <select class="form-group select2 form-control select2-multiple" name="pda"
                                        id="pdass" data-placeholder="{{ __('account.placeholder_pdass') }}" disabled>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-lg-4">
                                <label for="code" class="form-label col-form-label">Nama AUM</label>
                                <div class="col-lg-12">
                                    <input class="form-group form-control" type="text" id="name" name="name"
                                        placeholder="masukkan nama AUM" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label col-form-label">Pilih Bidang Usaha</label>
                                <div class="col-lg-12">
                                    <select class="form-group select2 form-control select2-multiple" name="bidangusaha"
                                        id="bidangusaha" required>
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
                                    <select class="form-group select2 form-control select2-multiple" name="kepemilikan"
                                        id="kepemilikan" required>
                                        <option selected disabled>Pilih Kepemilikan</option>
                                        @foreach ($kepemilikan as $key => $value)
                                            <option value="{{ $value->id_kepemilikan }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="address">Alamat</label>
                                    <textarea class="form-group form-control" type="text" name="address" id="address"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="address">Upload Foto-foto AUM</label>
                                <input class="form-control" type="file" name="images[]" id="images"
                                    multiple="multiple" accept="image/png, image/jpeg, image/jpg">
                            </div>
                            <div class="col-md-12">
                                <div class="user-image mb-3 text-center">
                                    <div class="imgPreview"></div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-3">
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
    <script>
        $(function() {
            // Multiple images preview with JavaScript
            var multiImgPreview = function(input, imgPreviewPlaceholder) {
                if (input.files) {
                    var filesAmount = input.files.length;
                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();
                        reader.onload = function(event) {
                            $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(
                                imgPreviewPlaceholder);
                        }
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            };
            $('#images').on('change', function() {
                multiImgPreview(this, 'div.imgPreview');
            });
        });
    </script>
@endsection
