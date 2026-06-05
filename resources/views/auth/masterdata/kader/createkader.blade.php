@extends('layouts.master')
@section('title')
    Create_Kader
@endsection
@section('css')
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />
    <style>
        .crop-container {
            max-height: 500px;
        }
        .crop-container img {
            max-width: 100%;
            display: block;
        }
    </style>
@endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            Kader
        @endslot
        @slot('title')
            Create New Kader
        @endslot
    @endcomponent
    <form action="/kader/create" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-12">
                <div id="addkader-accordion" class="custom-accordion">
                    @include('flashmessage')
                    <div class="card">
                        @csrf
                        <input type="hidden" value="{{ Auth::id() }}" name="id">
                        <input type="hidden" id="cropped_image" name="cropped_image" value="">
                        <a href="#addkader-personaldata-collapse" class="text-dark" data-bs-toggle="collapse"
                            aria-expanded="true" aria-controls="addkader-personaldata-collapse">
                            <div class="p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-xs">
                                            <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                01
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h6 class="font-size-16 mb-1">Kader Information - Personal Data</h6>
                                        <p class="text-muted text-truncate mb-0">Fill all information below</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                    </div>

                                </div>

                            </div>
                        </a>
                        <div id="addkader-personaldata-collapse" class="collapse show"
                            data-bs-parent="#addkader-accordion">
                            <div class="p-4 border-top">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="kader_name">Nama Lengkap</label>
                                            <input id="kader_name" name="kader_name" type="text" class="form-control"
                                                placeholder="Enter  Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="phone">Phone</label>
                                            <input id="phone" name="phone" type="text" class="form-control"
                                                placeholder="Enter phone">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="email">Email</label>
                                            <input id="email" name="email" type="email" class="form-control"
                                                placeholder="Enter email">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label" class="control-label">Pilih Jenis Kelamin</label>
                                            <select class="select2 form-control select2-multiple" name="gender"
                                                id="gender" data-live-search="true">
                                                <option selected disabled>Pilih Jenis Kelamin</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label" class="control-label">Pilih Status
                                                Pernikahan</label>
                                            <select class="select2 form-control select2-multiple" name="marital"
                                                id="marital" data-live-search="true">
                                                <option selected disabled>Pilih Status Pernikahan</option>
                                                <option value="Belum kawin">Belum kawin</option>
                                                <option value="Sudah kawin">Sudah kawin</option>
                                                <option value="Pernah kawin">Pernah kawin</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="anak">Jumlah Anak</label>
                                            <input id="anak" name="anak" type="number" class="form-control"
                                                placeholder="Enter jumlah anak">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label" class="control-label">Pilih Pekerjaan</label>
                                            <select class="select2 form-control select2-multiple" name="pekerjaan"
                                                id="pekerjaan" data-live-search="true">
                                                @foreach ($pekerjaan as $key => $value)
                                                    <option value="{{ $value->id_pekerjaan }}">
                                                        {{ $value->nama_pekerjaan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="profile_picture_input">Profile Picture</label>
                                            <input id="profile_picture_input" type="file" class="form-control"
                                                accept="image/png, image/jpeg">
                                            <div id="pp_preview_wrapper" style="display:none; margin-top:10px;">
                                                <img id="pp_preview" src="" class="img-thumbnail" style="max-height:120px;">
                                                <button type="button" class="btn btn-sm btn-outline-danger mt-1" id="pp_recrop">Crop Ulang</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="address">Alamat</label>
                                            <textarea class="form-control" name="address" id="address"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <a href="#addkader-aisyiyah-collapse" class="text-dark" data-bs-toggle="collapse"
                            aria-expanded="true" aria-controls="addkader-aisyiyah-collapse">
                            <div class="p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-xs">
                                            <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                02
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h6 class="font-size-16 mb-1">Kader Information - Aisyiyah Data</h6>
                                        <p class="text-muted text-truncate mb-0">Fill all information below</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                    </div>

                                </div>

                            </div>
                        </a>
                        <div id="addkader-aisyiyah-collapse" class="collapse show"
                            data-bs-parent="#addkader-accordion">
                            <div class="p-4 border-top">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="nbm">NBM</label>
                                            <input id="nbm" name="nbm" data-parsley-type="number"
                                                data-parsley-maxlength="7" class="form-control"
                                                placeholder="Enter  NBM">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="nba">NBA</label>
                                            <input id="nba" name="nba" data-parsley-type="number"
                                                data-parsley-maxlength="7" class="form-control"
                                                placeholder="Enter  NBA">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" class="control-label">Pilih Ranting</label>
                                            <select class="select2 form-select form-control select2-multiple"
                                                name="ranting" id="ranting" data-live-search="true">
                                                @foreach ($ranting as $key => $value)
                                                    <option value="{{ $value->ranting_id }}">
                                                        {{ $value->ranting_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6" id="divpca" style="display: none">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" class="control-label">Pilih PCA</label>
                                            <select class="form-select form-control" name="pca" id="pca"
                                                data-control="select2"
                                                data-placeholder="{{ __('account.placeholder_pca') }}">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="col-md-12 mb-3 mb-3">
                                            <label class="form-label" for="nbma">Scan/Foto NBM atau NBA</label>
                                            <input id="nbma" name="nbma" type="file" class="form-control"
                                                accept="image/png, image/jpeg" placeholder="#">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <a href="#addkader-edu-collapse" class="text-dark" data-bs-toggle="collapse"
                            aria-expanded="true" aria-controls="addkader-edu-collapse">
                            <div class="p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-xs">
                                            <div class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                03
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h6 class="font-size-16 mb-1">Kader Information - Pendidikan, Organisasi, dll</h6>
                                        <p class="text-muted text-truncate mb-0">Fill all information below</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <i class="mdi mdi-chevron-up accor-down-icon font-size-24"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div id="addkader-edu-collapse" class="collapse show"
                            data-bs-parent="#addkader-accordion">
                            <div class="p-4 border-top">
                                <div class="flex-grow-1 overflow-hidden">
                                    <h6 class="font-size-16 mb-1" style="display: inline;">Tambah Riwayat Pendidikan</h6>
                                    <button type="button" class="add1 btn btn-success btn-sm"
                                        style="margin-left: 10px;">+</button>
                                </div>

                                <div class="row" id="school">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" class="control-label">Pilih Jenjang
                                                Pendidikan</label>
                                            <select class="select2 form-select form-control select2-multiple"
                                                name="jenjang[]" data-live-search="true">
                                                <option selected disabled>Pilih Jenjang Pendidikan</option>
                                                <option value="SD">SD</option>
                                                <option value="SMP">SMP</option>
                                                <option value="SMA">SMA</option>
                                                <option value="S1">S1</option>
                                                <option value="S2">S2</option>
                                                <option value="S3">S3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="eduyear">Tahun Lulus</label>
                                            <input id="eduyear" name="eduyear[]" type="text" pattern="\d*" maxlength="4"
                                                class="form-control" placeholder="Enter Year">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div id="addkader-training-collapse" class="collapse show"
                            data-bs-parent="#addkader-accordion">
                            <div class="p-4 border-top">
                                <div class="flex-grow-1 overflow-hidden">
                                    <h6 class="font-size-16 mb-1" style="display: inline;">Tambah Riwayat Pelatihan</h6>
                                    <button type="button" class="add2 btn btn-success btn-sm"
                                        style="margin-left: 10px;">+</button>
                                </div>
                                <div class="row" id="training">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" class="control-label">Pilih Jenis Pelatihan</label>
                                            <select class="select2 form-select form-control select2-multiple"
                                                name="trainingtype[]" data-live-search="true">
                                                <option selected disabled>Pilih Jenis Pelatihan</option>
                                                <option value="Internal">Internal</option>
                                                <option value="Eksternal">Eksternal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="trainingname">Nama Pelatihan</label>
                                            <input id="trainingname" name="trainingname[]" type="text"
                                                class="form-control" placeholder="Enter Name">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div id="addkader-orgint-collapse" class="collapse show"
                            data-bs-parent="#addkader-accordion">
                            <div class="p-4 border-top">
                                <div class="flex-grow-1 overflow-hidden">
                                    <h6 class="font-size-16 mb-1" style="display: inline;">Tambah Riwayat Organisasi
                                        Aisyiyah</h6>
                                    <button type="button" class="add3 btn btn-success btn-sm"
                                        style="margin-left: 10px;">+</button>
                                </div>
                                <div class="row" id="organization">
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label class="form-label" class="control-label">Pilih Tingkat</label>
                                            <select class="select2 form-select form-control select2-multiple"
                                                name="orggrade[]" data-live-search="true">
                                                <option selected disabled>Pilih Tingkat</option>
                                                <option value="PPA">PPA</option>
                                                <option value="PWA">PWA</option>
                                                <option value="PDA">PDA</option>
                                                <option value="PCA">PCA</option>
                                                <option value="PRA">PRA</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="orgintjabatan">Jabatan</label>
                                            <input id="orgintjabatan" name="orgintjabatan[]" type="text"
                                                class="form-control" placeholder="Enter Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="orgintstart">Tahun Mulai</label>
                                            <input id="orgintstart" name="orgintstart[]" class="form-control"
                                                placeholder="Enter Year" type="text" pattern="\d*" maxlength="4">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="orgintend">Tahun Selesai</label>
                                            <input id="orgintend" name="orgintend[]" class="form-control"
                                                placeholder="Enter Year" type="text" pattern="\d*" maxlength="4">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div id="addkader-orgext-collapse" class="collapse show"
                            data-bs-parent="#addkader-accordion">
                            <div class="p-4 border-top">
                                <div class="flex-grow-1 overflow-hidden">
                                    <h6 class="font-size-16 mb-1" style="display: inline;">Tambah Riwayat Organisasi
                                        non-Aisyiyah</h6>
                                    <button type="button" class="add4 btn btn-success btn-sm"
                                        style="margin-left: 10px;">+</button>
                                </div>
                                <div class="row" id="organizationex">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label" class="control-label">Nama Organisasi</label>
                                            <input id="orgextname" name="orgextname[]" type="text"
                                                class="form-control" placeholder="Enter Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="orgextjabatan">Jabatan</label>
                                            <input id="orgextjabatan" name="orgextjabatan[]" type="text"
                                                class="form-control" placeholder="Enter Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="orgextstart">Tahun Mulai</label>
                                            <input id="orgextstart" name="orgextstart[]"
                                                class="form-control" placeholder="Enter Year" type="text" pattern="\d*" maxlength="4">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="orgextend">Tahun Selesai</label>
                                            <input id="orgextend" name="orgextend[]" class="form-control"
                                                placeholder="Enter Year" type="text" pattern="\d*" maxlength="4">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!----tombol--------->
            <div class="row mb-4">
                <div class="col ms-auto">
                    <div class="d-flex flex-wrap gap-3">
                        <button type="submit" class="btn btn-primary waves-effect waves-light"
                            id="sa-add-success">Simpan</button>
                    </div>
                </div><!-- end col -->
            </div>
            <!-----end-tombol----->
        </div>
    </form>

    <!-- Crop Modal -->
    <div class="modal fade" id="cropModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="cropModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cropModalLabel">Crop Foto Profile (Ratio 3:4)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="crop-container">
                        <img id="crop_image" src="" alt="Crop Preview">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="crop_button">Crop & Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/js/account.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script>
        // --- Cropper setup ---
        var cropper;
        var cropModal;

        document.addEventListener('DOMContentLoaded', function() {
            cropModal = new bootstrap.Modal(document.getElementById('cropModal'));

            document.getElementById('profile_picture_input').addEventListener('change', function(e) {
                var file = e.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(ev) {
                        document.getElementById('crop_image').src = ev.target.result;
                        cropModal.show();
                    };
                    reader.readAsDataURL(file);
                }
            });

            document.getElementById('cropModal').addEventListener('shown.bs.modal', function() {
                var image = document.getElementById('crop_image');
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(image, {
                    aspectRatio: 3 / 4,
                    viewMode: 2,
                    autoCropArea: 1,
                    responsive: true,
                    background: false,
                });
            });

            document.getElementById('cropModal').addEventListener('hidden.bs.modal', function() {
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
            });

            document.getElementById('crop_button').addEventListener('click', function() {
                if (cropper) {
                    var canvas = cropper.getCroppedCanvas({
                        width: 450,
                        height: 600,
                    });
                    var dataUrl = canvas.toDataURL('image/jpeg', 0.9);
                    document.getElementById('cropped_image').value = dataUrl;
                    document.getElementById('pp_preview').src = dataUrl;
                    document.getElementById('pp_preview_wrapper').style.display = 'block';
                    document.getElementById('crop_image').src = '';
                    cropModal.hide();
                }
            });

            document.getElementById('pp_recrop').addEventListener('click', function() {
                document.getElementById('profile_picture_input').value = '';
                document.getElementById('profile_picture_input').click();
            });
        });

        // --- Dynamic fields ---
        $('.add1').on('click', add1);
        function add1() {
            var new_input =
                '<div class="col-lg-6"><div class="mb-3"><select class="select2 form-select form-control select2-multiple" name="jenjang[]" data-live-search="true"><option value="SD">SD</option><option value="SMP">SMP</option><option value="SMA">SMA</option><option value="S1">S1</option><option value="S2">S2</option><option value="S3">S3</option></select></div></div><div class="col-lg-6"><div class="col-md-12 mb-3"><input name="eduyear[]" type="text" pattern="\\d*" maxlength="4" class="form-control" placeholder="Enter Year"></div></div>'
            $('#school').append(new_input);
        }

        $('.add2').on('click', add2);
        function add2() {
            var new_input =
                '<div class="col-lg-6"><div class="mb-3"><select class="select2 form-select form-control select2-multiple" name="trainingtype[]" data-live-search="true"><option selected disabled>Pilih Jenis Pelatihan</option><option value="Internal">Internal</option><option value="Eksternal">Eksternal</option></select></div></div><div class="col-lg-6"><div class="col-md-12 mb-3"><input name="trainingname[]" type="text" class="form-control" placeholder="Enter Name"></div></div>'
            $('#training').append(new_input);
        }

        $('.add3').on('click', add3);
        function add3() {
            var new_input =
                '<div class="col-lg-3"><div class="mb-3"><select class="select2 form-select form-control select2-multiple" name="orggrade[]" data-live-search="true"><option selected disabled>Pilih Tingkat</option><option value="PPA">PPA</option><option value="PWA">PWA</option><option value="PDA">PDA</option><option value="PCA">PCA</option><option value="PRA">PRA</option></select></div></div><div class="col-lg-5"><div class="col-md-12 mb-3"><input name="orgintjabatan[]" type="text" class="form-control" placeholder="Enter Name"></div></div><div class="col-lg-2"><div class="col-md-12 mb-3"><input name="orgintstart[]" type="text" pattern="\\d*" maxlength="4" class="form-control" placeholder="Enter Year"></div></div><div class="col-lg-2"><div class="col-md-12 mb-3"><input name="orgintend[]" type="text" pattern="\\d*" maxlength="4" class="form-control" placeholder="Enter Year"></div></div>'
            $('#organization').append(new_input);
        }

        $('.add4').on('click', add4);
        function add4() {
            var new_input =
                '<div class="col-lg-4"><div class="mb-3"><input name="orgextname[]" type="text" class="form-control" placeholder="Enter Name"></div></div><div class="col-lg-4"><div class="col-md-12 mb-3"><input name="orgextjabatan[]" type="text" class="form-control" placeholder="Enter Name"></div></div><div class="col-lg-2"><div class="col-md-12 mb-3"><input name="orgextstart[]" type="text" pattern="\\d*" maxlength="4" class="form-control" placeholder="Enter Year"></div></div><div class="col-lg-2"><div class="col-md-12 mb-3"><input name="orgextend[]" type="text" pattern="\\d*" maxlength="4" class="form-control" placeholder="Enter Year"></div></div>'
            $('#organizationex').append(new_input);
        }
    </script>
@endsection